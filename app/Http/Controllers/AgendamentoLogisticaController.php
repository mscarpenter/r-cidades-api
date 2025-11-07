<?php

namespace App\Http\Controllers;

use App\Models\AgendamentoLogistica; // Importe o Model
use Illuminate\Http\Request;

class AgendamentoLogisticaController extends Controller
{
    /**
     * Exibe uma lista de todos os agendamentos.
     */
    public function index()
    {
        $agendamentos = AgendamentoLogistica::all();
        return response()->json($agendamentos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Não usado em APIs
    }

    /**
     * Salva um novo agendamento no banco de dados.
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados
        $validatedData = $request->validate([
            'solicitacao_id' => 'required|exists:solicitacaos,id', // Verifica se a solicitação existe
            'data_agendada' => 'required|date', // Garante que é uma data válida
            'transportador_id' => 'nullable|exists:users,id' // Opcional, mas se existir, deve ser um usuário válido
        ]);

        // 2. Criação do Agendamento
        $agendamento = AgendamentoLogistica::create([
            'solicitacao_id' => $validatedData['solicitacao_id'],
            'transportador_id' => $validatedData['transportador_id'] ?? null, // Pega o ID ou define nulo
            'data_agendada' => $validatedData['data_agendada'],
            'status_logistica' => 'Agendada', // Define o padrão
        ]);

        // 3. Resposta: Retorna o agendamento criado
        return response()->json($agendamento, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AgendamentoLogistica $agendamentoLogistica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgendamentoLogistica $agendamentoLogistica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AgendamentoLogistica $agendamentoLogistica)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgendamentoLogistica $agendamentoLogistica)
    {
        //
    }
}