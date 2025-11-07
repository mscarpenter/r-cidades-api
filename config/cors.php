<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configurações de Cross-Origin Resource Sharing (CORS)
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*'], // Aplica estas regras para todas as suas rotas de API

    'allowed_methods' => ['*'], // Permite todos os métodos (GET, POST, PUT, etc)

    'allowed_origins' => [
        'http://localhost:5173', // A porta original
        'http://localhost:5174', // A nova porta que o Vite escolheu
        'http://localhost:5175',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Permite todos os headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];