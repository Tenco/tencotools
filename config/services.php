<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET_KEY'),
    ],


    'google' => [
        'client_id' => env('GOOGLE_APP_CLIENT_ID'), 
        'client_secret' => env('GOOGLE_CLIENT_SECRET'), 
        'redirect' => env('REDIRECT'), 
    ],


];
