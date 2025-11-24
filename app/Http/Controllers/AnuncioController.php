<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Http\Requests\StoreAnuncioRequest;
use App\Http\Requests\UpdateAnuncioRequest;

use Illuminate\Http\Request;

class AnuncioController extends Controller
{
    /**
     * Listar todos os anúncios disponíveis com filtros
     */
    public function index(Request $request)
    {
        $query = Anuncio::with('usuario', 'categoriaMaterial')
            ->where('status', 'disponivel');

        // Aplica os filtros usando os scopes do Model
        $query->search($request->input('search'))
              ->categoria($request->input('categoria_id'))
              ->condicao($request->input('condicao'))
              ->localizacao($request->input('cidade'), $request->input('estado'));

        $anuncios = $query->latest()->get();
            
        return response()->json($anuncios);
    }

    /**
     * Criar um novo anúncio
     */
    public function store(StoreAnuncioRequest $request)
    {
        // Os dados já vêm validados e com usuario_id do FormRequest
        $anuncio = Anuncio::create($request->validated());

        // Retorna o anúncio com o relacionamento do usuário
        $anuncio->load('usuario');

        return response()->json($anuncio, 201);
    }

    /**
     * Exibir um anúncio específico
     */
    public function show(Anuncio $anuncio)
    {
        // Carrega os relacionamentos
        $anuncio->load('usuario', 'categoriaMaterial', 'solicitacoes.beneficiario');
        
        return response()->json($anuncio);
    }

    /**
     * Atualizar um anúncio existente
     */
    public function update(UpdateAnuncioRequest $request, Anuncio $anuncio)
    {
        // A autorização já foi verificada no FormRequest
        $anuncio->update($request->validated());

        $anuncio->load('usuario', 'categoriaMaterial');

        return response()->json($anuncio);
    }

    /**
     * Remover um anúncio (soft delete via status)
     */
    public function destroy(Anuncio $anuncio)
    {
        // Verifica se o usuário é o dono do anúncio
        if ($anuncio->usuario_id !== auth()->id()) {
            return response()->json([
                'message' => 'Você não tem permissão para excluir este anúncio.'
            ], 403);
        }

        // Ao invés de deletar, muda o status para cancelado
        $anuncio->update(['status' => 'cancelado']);

        return response()->json([
            'message' => 'Anúncio cancelado com sucesso.'
        ]);
    }
}