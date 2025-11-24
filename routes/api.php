<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\SolicitacaoController;
use App\Http\Controllers\AgendamentoLogisticaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriaMaterialController;
use App\Http\Controllers\BancoDeMaterialController;

// --- Rotas Públicas (Não precisam de login) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/categorias', [CategoriaMaterialController::class, 'index']); // Listar categorias
Route::get('/bancos-materiais', [BancoDeMaterialController::class, 'index']); // Listar bancos
Route::get('/bancos-materiais/{bancoDeMaterial}', [BancoDeMaterialController::class, 'show']); // Ver banco

Route::get('/anuncios', [AnuncioController::class, 'index']); // Ver catálogo
Route::get('/anuncios/{anuncio}', [AnuncioController::class, 'show']); // Ver detalhe

// Rota do Dashboard (Pública por enquanto)
Route::get('/dashboard', [DashboardController::class, 'index']);

// --- Rotas Protegidas (Precisa estar logado com Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Bancos de Materiais (Gestão)
    Route::post('/bancos-materiais', [BancoDeMaterialController::class, 'store']);
    Route::put('/bancos-materiais/{bancoDeMaterial}', [BancoDeMaterialController::class, 'update']);
    Route::delete('/bancos-materiais/{bancoDeMaterial}', [BancoDeMaterialController::class, 'destroy']);

    // Logística e Agendamento
    Route::get('/agendamentos', [AgendamentoLogisticaController::class, 'index']); // Listar meus agendamentos
    Route::post('/agendamentos', [AgendamentoLogisticaController::class, 'store']); // Criar agendamento
    Route::put('/agendamentos/{agendamento}', [AgendamentoLogisticaController::class, 'update']); // Atualizar status

    // Perfil do Usuário
    Route::get('/profile', [ProfileController::class, 'show']); // Ver perfil
    Route::put('/profile', [ProfileController::class, 'update']); // Atualizar perfil
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']); // Alterar senha
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar']); // Upload avatar
    Route::get('/meus-anuncios', [ProfileController::class, 'meusAnuncios']); // Meus anúncios

    Route::get('/minhas-solicitacoes', [SolicitacaoController::class, 'minhasSolicitacoes']); // Minhas solicitações
    Route::post('/solicitacoes/{id}/cancelar', [SolicitacaoController::class, 'cancelar']); // Cancelar solicitação

    // Anúncios (CRUD completo)
    Route::post('/anuncios', [AnuncioController::class, 'store']); // Criar anúncio
    Route::put('/anuncios/{anuncio}', [AnuncioController::class, 'update']); // Editar anúncio
    Route::delete('/anuncios/{anuncio}', [AnuncioController::class, 'destroy']); // Excluir anúncio
    
    // Upload de imagens para anúncios
    Route::post('/anuncios/{anuncio}/imagens', [ImagemAnuncioController::class, 'upload']); // Upload de imagens
    Route::delete('/anuncios/{anuncio}/imagens', [ImagemAnuncioController::class, 'destroy']); // Remover imagem

    // Solicitações
    Route::post('/solicitacoes', [SolicitacaoController::class, 'store']); // Criar solicitação
    Route::get('/solicitacoes/{solicitacao}', [SolicitacaoController::class, 'show']); // Ver detalhes
    
    // Minhas solicitações (como beneficiário)
    Route::get('/minhas-solicitacoes', [SolicitacaoController::class, 'minhasSolicitacoes']);
    
    // Solicitações recebidas (como doador)
    Route::get('/solicitacoes-recebidas', [SolicitacaoController::class, 'solicitacoesRecebidas']);
    
    // Aprovar/Rejeitar solicitações (como doador)
    Route::patch('/solicitacoes/{solicitacao}/aprovar', [SolicitacaoController::class, 'aprovar']);
    Route::patch('/solicitacoes/{solicitacao}/rejeitar', [SolicitacaoController::class, 'rejeitar']);
    
    // Cancelar solicitação (como beneficiário)
    Route::patch('/solicitacoes/{solicitacao}/cancelar', [SolicitacaoController::class, 'cancelar']);

    // Logística (Admin)
    Route::get('/solicitacoes', [SolicitacaoController::class, 'index']); // Ver todas
    Route::get('/agendamentos', [AgendamentoLogisticaController::class, 'index']); // Ver todos
    Route::post('/agendamentos', [AgendamentoLogisticaController::class, 'store']); // Criar um
});