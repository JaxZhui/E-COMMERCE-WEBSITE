<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free sto adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'api/auth/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:3000',    
        'http://10.119.27.90:3000', 
        'http://10.119.27.90:8000',
        'http://127.0.0.1:8000', 
        'http://localhost:3000',
            // Alternative localhost
        // Add your production frontend URLs here
        // 'https://yourdomain.com',
        // 'https://www.yourdomain.com',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => ['Authorization'],

    'max_age' => 0,

    'supports_credentials' => true,

];
