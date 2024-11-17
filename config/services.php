<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'maxim_excel' => [
        'host' => env('SERVICE_EXCEL_HOST', '127.0.0.1'),
        'port' => env('SERVICE_EXCEL_PORT', 8080),
    ],

    'maxim_auth' => [
        'host' => env('SERVICE_AUTH_HOST', '127.0.0.1'),
        'port' => env('SERVICE_AUTH_PORT', 8080),
    ],
];
