<?php

declare(strict_types=1);

return [
    'database' => [
        'connection' => [
            'host' => env('DB_HOST', 'localhost'),
            'port' => (int) env('DB_PORT', 3306),
            'dbname' => env('DB_DATABASE', 'plain_kit_ledger'),
            'charset' => 'utf8mb4',
        ],
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
    ],
];
