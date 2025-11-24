<?php

namespace App\Http\Controllers;

use App\Models\AgendamentoLogistica;
use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendamentoLogisticaController extends Controller
{
    /**
     * Listar agendamentos do usuário logado
     */
    public function index()
    {
        $userId = Auth::id();

        // Busca agendamentos onde o usuário é beneficiário (via solicitação) ou doador (via anúncio da solicitação)
        $agendamentos = AgendamentoLogistica::whereHas('solicitacao', function ($query) use ($userId) {
            $query->where('beneficiario_id', $userId)
                  ->orWhereHas('anuncio', function ($q) use ($userId) {
                      $q->where('usuario_id', $userId);
                  });
        })
        ->with('solicitacao.anuncio', 'solicitacao.beneficiario')
        ->orderBy('data_agendada', 'asc')
        ->get();

        return response()->json($agendamentos);
    }

    /**
     * Criar um novo agendamento
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'solicitacao_id' => 'required|exists:solicitacaos,id',
            'data_agendada' => 'required|date|after:now',
        ]);

        $solicitacao = Solicitacao::findOrFail($validatedData['solicitacao_id']);

        // Verifica permissão: Apenas beneficiário ou doador podem agendar
        if ($solicitacao->beneficiario_id !== Auth::id() && $solicitacao->anuncio->usuario_id !== Auth::id()) {
            return response()->json(['message' => 'Não autorizado.'], 403);
        }

        // Verifica status da solicitação
        if ($solicitacao->status !== 'Aprovada') {
            return response()->json(['message' => 'A solicitação precisa estar Aprovada para ser agendada.'], 422);
        }

        $agendamento = AgendamentoLogistica::create([
            'solicitacao_id' => $solicitacao->id,
            'data_agendada' => $validatedData['data_agendada'],
            'status_logistica' => 'Agendada',
        ]);

        return response()->json($agendamento, 201);
    }

    /**
     * Atualizar status do agendamento (Confirmar retirada/entrega)
     */
    public function update(Request $request, AgendamentoLogistica $agendamento)
    {
        // Carrega relacionamentos para verificação
        $agendamento->load('solicitacao.anuncio');
        
        $userId = Auth::id();
        $isBeneficiario = $agendamento->solicitacao->beneficiario_id === $userId;
        $isDoador = $agendamento->solicitacao->anuncio->usuario_id === $userId;

        if (!$isBeneficiario && !$isDoador) {
            return response()->json(['message' => 'Não autorizado.'], 403);
        }

        $validatedData = $request->validate([
            'status_logistica' => 'sometimes|in:Agendada,Coletada,Entregue,Cancelada',
            'confirmacao_retirada' => 'sometimes|boolean',
            'confirmacao_entrega' => 'sometimes|boolean',
        ]);

        $agendamento->update($validatedData);

        // Lógica de atualização de status baseada nas confirmações
        if ($agendamento->confirmacao_retirada && $agendamento->status_logistica === 'Agendada') {
            $agendamento->update(['status_logistica' => 'Coletada']);
        }

        if ($agendamento->confirmacao_entrega && $agendamento->status_logistica === 'Coletada') {
            $agendamento->update(['status_logistica' => 'Entregue']);
            
            // Atualiza o status do anúncio para "Doado"
            $anuncio = $agendamento->solicitacao->anuncio;
            $anuncio->update(['status' => 'doado']);

            // --- GAMIFICAÇÃO: Atribuir pontos ao doador ---
            $doador = $anuncio->usuario;
            $pontosBase = 10;
            $pontosPeso = $anuncio->peso_estimado_kg ? floor($anuncio->peso_estimado_kg) : 0;
            
            $doador->increment('pontos', $pontosBase + $pontosPeso);
        }

        return response()->json($agendamento);
    }
}