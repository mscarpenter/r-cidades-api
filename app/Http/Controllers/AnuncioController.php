<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnuncioController extends Controller
{
    public function index()
    {
        $anuncios = Anuncio::all(); 
        return response()->json($anuncios);
    }

    public function create()
    {
        // Não usado em APIs
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'quantidade' => 'required|string|max:100',
            'condicao' => 'required|string|max:100',
        ]);

        $userId = Auth::id(); 

        $anuncio = Anuncio::create([
            'usuario_id' => $userId,
            'titulo' => $validatedData['titulo'],
            'descricao' => $validatedData['descricao'],
            'quantidade' => $validatedData['quantidade'],
            'condicao' => $validatedData['condicao'],
            'status' => 'Publicado',
        ]);

        return response()->json($anuncio, 201);
    }

    public function show(Anuncio $anuncio)
    {
        return response()->json($anuncio);
    }

    public function edit(Anuncio $anuncio)
    {
        // Não usado em APIs
    }

    public function update(Request $request, Anuncio $anuncio)
    {
        //
    }

    public function destroy(Anuncio $anuncio)
    {
        //
    }
}