<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitacaoController extends Controller
{
    /**
     * Exibe uma lista de todas as solicitações.
     */
    public function index()
    {
        $solicitacoes = Solicitacao::all();
        return response()->json($solicitacoes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Não usado em APIs
    }

    /**
     * Salva uma nova solicitação no banco de dados.
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados
        $validatedData = $request->validate([
            'anuncio_id' => 'required|exists:anuncios,id', // Verifica se o anúncio existe
            'justificativa_beneficiario' => 'required|string|min:10', // Garante uma justificativa mínima
        ]);

        // 2. Pega o ID do usuário logado
        $beneficiarioId = Auth::id();

        // 3. Criação da Solicitação
        $solicitacao = Solicitacao::create([
            'anuncio_id' => $validatedData['anuncio_id'],
            'justificativa_beneficiario' => $validatedData['justificativa_beneficiario'],
            'beneficiario_id' => $beneficiarioId, 
            'status' => 'Pendente',
        ]);

        // 4. Resposta: Retorna a solicitação criada
        return response()->json($solicitacao, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Solicitacao $solicitacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solicitacao $solicitacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solicitacao $solicitacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitacao $solicitacao)
    {
        //
    }
}