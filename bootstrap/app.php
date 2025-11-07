<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException; // 1. IMPORTANTE: Adicione este 'use'
use Illuminate\Http\Request; // 2. IMPORTANTE: Adicione este 'use'

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Esta linha já deve existir
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // (Aqui fica vazio por enquanto)
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        // 3. ADICIONE ESTE BLOCO DE CÓDIGO
        // Este é o "handler" que captura o erro de login
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            
            // Se a requisição foi para uma rota de API...
            if ($request->is('api/*')) {
                // ...retorne um JSON de erro 401, em vez de redirecionar.
                return response()->json([
                    'message' => 'Unauthenticated.' // A mensagem de erro que queríamos
                ], 401);
            }
        });
        // --- FIM DO BLOCO ---

    })->create();