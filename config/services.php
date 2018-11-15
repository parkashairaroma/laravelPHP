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

    'mandrill' => [
        'secret' => env('MANDRILL_KEY'),
    ],
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_APPID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => url(env('FACEBOOK_URL')),
    ],
    'stripe' => [
        'secret' => ENV('STRIPE_SECRET'),
    ],
];
