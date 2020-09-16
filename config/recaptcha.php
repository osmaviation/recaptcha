<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Keys
    |--------------------------------------------------------------------------
    |
    | Set the public and private API keys as provided by reCAPTCHA.
    |
    | In version 2 of reCAPTCHA, public_key is the Site key,
    | and private_key is the Secret key.
    |
    */
    'public_key'     => env('RECAPTCHA_PUBLIC_KEY', ''),
    'private_key'    => env('RECAPTCHA_PRIVATE_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Template
    |--------------------------------------------------------------------------
    |
    | Set a template to use if you don't want to use the standard one.
    |
    */
    'template'    => '',

    /*
    |--------------------------------------------------------------------------
    | Driver
    |--------------------------------------------------------------------------
    |
    | Determine the http-client class.
    | Only applies to v2/v3.
    |
    */
    'driver'      => \OSMAviation\Recaptcha\Tools\Driver\Guzzle::class,

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | Various options for the drivers
    |
    */
    'options'     => [
        'timeout' => 1,
        'curl_verify' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    |
    | Set which version of ReCaptcha to use.
    |
    */

    'version'     => env('RECAPTCHA_VERSION', 3),

    /*
    |--------------------------------------------------------------------------
    | V3 specific options
    |--------------------------------------------------------------------------
    |
    | Please see reCAPTCHA v3 documentation https://developers.google.com/recaptcha/docs/v3
    |
    */

    'threshold' => env('RECAPTCHA_V3_THRESHOLD', 0.5),
    'actions' => [
        'register' => 'register'
    ]

];
