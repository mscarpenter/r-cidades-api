<?php

namespace App\Http\Controllers;

use App\Models\BancoDeMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BancoDeMaterialController extends Controller
{
    /**
     * Listar todos os bancos de materiais
     */
    public function index()
    {
        $bancos = BancoDeMaterial::with('responsavel')->get();
        return response()->json($bancos);
    }

    /**
     * Criar um novo banco de materiais
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        $validatedData['responsavel_usuario_id'] = Auth::id();

        $banco = BancoDeMaterial::create($validatedData);

        return response()->json($banco, 201);
    }

    /**
     * Exibir detalhes de um banco
     */
    public function show(BancoDeMaterial $bancoDeMaterial)
    {
        $bancoDeMaterial->load('responsavel', 'anuncios.usuario');
        return response()->json($bancoDeMaterial);
    }

    /**
     * Atualizar um banco de materiais
     */
    public function update(Request $request, BancoDeMaterial $bancoDeMaterial)
    {
        // Verifica se o usuário é o responsável
        if ($bancoDeMaterial->responsavel_usuario_id !== Auth::id()) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $validatedData = $request->validate([
            'nome' => 'sometimes|string|max:255',
            'endereco' => 'sometimes|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        $bancoDeMaterial->update($validatedData);

        return response()->json($bancoDeMaterial);
    }

    /**
     * Remover um banco de materiais
     */
    public function destroy(BancoDeMaterial $bancoDeMaterial)
    {
        // Verifica se o usuário é o responsável
        if ($bancoDeMaterial->responsavel_usuario_id !== Auth::id()) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $bancoDeMaterial->delete();

        return response()->json(['message' => 'Banco de materiais removido com sucesso']);
    }
}
