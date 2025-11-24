<?php

namespace App\Http\Controllers;

use App\Models\CategoriaMaterial;
use Illuminate\Http\Request;

class CategoriaMaterialController extends Controller
{
    /**
     * Listar todas as categorias
     */
    public function index()
    {
        $categorias = CategoriaMaterial::orderBy('nome')->get();
        return response()->json($categorias);
    }

    /**
     * Criar nova categoria (apenas admin - futuro)
     */
    public function store(Request $request)
    {
        // Implementação futura para admin
    }
}
