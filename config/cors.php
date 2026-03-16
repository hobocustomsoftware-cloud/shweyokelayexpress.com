<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:19006',
        'http://localhost:19000',
        'http://localhost:8081',
        'http://localhost:8080',
        'http://localhost:3000',
        'http://127.0.0.1:19006',
        'http://127.0.0.1:19000',
        'http://127.0.0.1:8081',
        'http://127.0.0.1:8080',
        'http://127.0.0.1:3000',
    ],

    'allowed_origins_patterns' => [
        '#^https?://localhost(:\d+)?$#',
        '#^https?://127\.0\.0\.1(:\d+)?$#',
        '#^https?://192\.168\.\d+\.\d+(:\d+)?$#',
        '#^https?://10\.\d+\.\d+\.\d+(:\d+)?$#',
        '#^exp://#',
        '#^null$#',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => ['Authorization'],

    'max_age' => 86400,

    'supports_credentials' => true,

];
