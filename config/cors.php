<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'register', 'forgot-password', 'reset-password'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://library4edu.netlify.app', 'http://localhost:5173'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => ['*'],
    'max_age' => 86400,
    'supports_credentials' => true,
];
