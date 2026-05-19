<?php

return [
    'name'     => env('APP_NAME', 'Cabaiku'),
    'env'      => env('APP_ENV', 'production'),
    'debug'    => (bool) env('APP_DEBUG', false),
    'url'      => env('APP_URL', 'http://localhost'),
    'timezone' => 'Asia/Jakarta',
    'locale'   => 'id',
    'fallback_locale' => 'en',
    'faker_locale'    => 'id_ID',
    'ai_service_url' => env('AI_SERVICE_URL', 'http://127.0.0.1:5000'),
    'cipher'   => 'AES-256-CBC',
    'key'      => env('APP_KEY'),
    'previous_keys' => array_filter(explode(',', env('APP_PREVIOUS_KEYS', ''))),
    'maintenance' => ['driver' => 'file'],
];
