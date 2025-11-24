<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use App\Models\Anuncio;
use App\Http\Requests\StoreSolicitacaoRequest;
use Illuminate\Http\Request;

class SolicitacaoController extends Controller
{
    /**
     * Listar todas as solicitações (Admin)
     */
    public function index()
    {
        $solicitacoes = Solicitacao::with('anuncio', 'beneficiario')
            ->latest()
            ->get();
            
        return response()->json($solicitacoes);
    }

    /**
     * Criar uma nova solicitação
     */
    public function store(StoreSolicitacaoRequest $request)
    {
        // Os dados já vêm validados e com beneficiario_id do FormRequest
        $solicitacao = Solicitacao::create($request->validated());

        // Retorna a solicitação com os relacionamentos
        $solicitacao->load('anuncio.usuario', 'beneficiario');

        return response()->json($solicitacao, 201);
    }

    /**
     * Exibir uma solicitação específica
     */
    public function show(Solicitacao $solicitacao)
    {
        $solicitacao->load('anuncio.usuario', 'beneficiario', 'agendamento');
        
        return response()->json($solicitacao);
    }

    /**
     * Listar solicitações feitas pelo usuário logado (como beneficiário)
     */
    public function minhasSolicitacoes()
    {
        $solicitacoes = Solicitacao::with('anuncio.usuario', 'agendamento')
            ->where('beneficiario_id', auth()->id())
            ->latest()
            ->get();

        return response()->json($solicitacoes);
    }

    /**
     * Listar solicitações recebidas nos anúncios do usuário logado (como doador)
     */
    public function solicitacoesRecebidas()
    {
        // Busca IDs dos anúncios do usuário
        $anunciosIds = Anuncio::where('usuario_id', auth()->id())
            ->pluck('id');

        // Busca solicitações desses anúncios
        $solicitacoes = Solicitacao::with('anuncio', 'beneficiario')
            ->whereIn('anuncio_id', $anunciosIds)
            ->latest()
            ->get();

        return response()->json($solicitacoes);
    }

    /**
     * Aprovar uma solicitação (apenas o dono do anúncio)
     */
    public function aprovar(Request $request, Solicitacao $solicitacao)
    {
        // Verifica se o usuário é o dono do anúncio
        if ($solicitacao->anuncio->usuario_id !== auth()->id()) {
            return response()->json([
                'message' => 'Você não tem permissão para aprovar esta solicitação.'
            ], 403);
        }

        // Atualiza o status
        $solicitacao->update([
            'status' => 'aprovada',
        ]);

        // Opcional: atualizar status do anúncio para reservado
        $solicitacao->anuncio->update(['status' => 'reservado']);

        $solicitacao->load('anuncio', 'beneficiario');

        return response()->json([
            'message' => 'Solicitação aprovada com sucesso!',
            'solicitacao' => $solicitacao
        ]);
    }

    /**
     * Rejeitar uma solicitação (apenas o dono do anúncio)
     */
    public function rejeitar(Request $request, Solicitacao $solicitacao)
    {
        // Verifica se o usuário é o dono do anúncio
        if ($solicitacao->anuncio->usuario_id !== auth()->id()) {
            return response()->json([
                'message' => 'Você não tem permissão para rejeitar esta solicitação.'
            ], 403);
        }

        // Validação opcional de mensagem
        $validated = $request->validate([
            'mensagem_doador' => 'nullable|string|max:500'
        ]);

        // Atualiza o status
        $solicitacao->update([
            'status' => 'rejeitada',
            'mensagem_doador' => $validated['mensagem_doador'] ?? null,
        ]);

        $solicitacao->load('anuncio', 'beneficiario');

        return response()->json([
            'message' => 'Solicitação rejeitada.',
            'solicitacao' => $solicitacao
        ]);
    }

    /**
     * Cancelar uma solicitação (apenas o beneficiário)
     */
    public function cancelar(Solicitacao $solicitacao)
    {
        // Verifica se o usuário é o beneficiário
        if ($solicitacao->beneficiario_id !== auth()->id()) {
            return response()->json([
                'message' => 'Você não tem permissão para cancelar esta solicitação.'
            ], 403);
        }

        $solicitacao->update(['status' => 'cancelada']);

        return response()->json([
            'message' => 'Solicitação cancelada com sucesso.'
        ]);
    }
}