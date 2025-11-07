<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\SolicitacaoController;
use App\Http\Controllers\AgendamentoLogisticaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; // 1. Importe o novo Controller

// --- Rotas Públicas (Não precisam de login) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/anuncios', [AnuncioController::class, 'index']); // Ver catálogo
Route::get('/anuncios/{anuncio}', [AnuncioController::class, 'show']); // Ver detalhe

// Rota do Dashboard (Pública por enquanto)
Route::get('/dashboard', [DashboardController::class, 'index']); // 2. Adicione esta rota

// --- Rotas Protegidas (Precisa estar logado com Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Anúncios
    Route::post('/anuncios', [AnuncioController::class, 'store']); // Criar anúncio

    // Solicitações
    Route::post('/solicitacoes', [SolicitacaoController::class, 'store']); // Criar solicitação

    // Logística (Admin)
    Route::get('/solicitacoes', [SolicitacaoController::class, 'index']); // Ver todas
    Route::get('/agendamentos', [AgendamentoLogisticaController::class, 'index']); // Ver todos
    Route::post('/agendamentos', [AgendamentoLogisticaController::class, 'store']); // Criar um
});