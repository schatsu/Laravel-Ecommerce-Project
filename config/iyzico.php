<?php

return [
    /*
    |--------------------------------------------------------------------------
    | iyzico API Credentials
    |--------------------------------------------------------------------------
    |
    | Sandbox için: https://sandbox-api.iyzipay.com
    | Production için: https://api.iyzipay.com
    |
    */

    'api_key' => env('IYZICO_API_KEY', ''),
    'secret_key' => env('IYZICO_SECRET_KEY', ''),
    'base_url' => env('IYZICO_BASE_URL', 'https://sandbox-api.iyzipay.com'),

    /*
    |--------------------------------------------------------------------------
    | Callback URLs
    |--------------------------------------------------------------------------
    */

    'callback_url' => env('IYZICO_CALLBACK_URL', '/odeme/callback'),
];
