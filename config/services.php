<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    // 'facebook_poster' => [
    //     'app_id' => getenv('FACEBOOK_APP_ID', '584857442336768'),
    //     'app_secret' => getenv('FACEBOOK_APP_SECRET', 'd8cffd5f033b81df8a9d9845c3528e66'),
    //     'access_token' => getenv('FACEBOOK_ACCESS_TOKEN', 'EAAIT7LwYQAABAFEK0wV0YqQYTR9atKPXZBZA99RvQUmXpwZBvHZAcZAx22g9H4n9u6QXobzeKKfOd32wxThVPEBeZBUHUXhWMnezd4WWCz2b5pEXPvKD6Yq5xhZCCPz4jBvdQGOEMz7Qq2st3QQXg6TzBfchXEpPkehCaIinn5ZCaoiJZBeseF8qOMFugzdEPCNmsGBT7XaLdWAZDZD'),
    // ],

    'facebook_poster' => [
        'client_id' => getenv('FACEBOOK_APP_ID', '584857442336768'),
        'client_secret' => getenv('FACEBOOK_APP_SECRET', 'd8cffd5f033b81df8a9d9845c3528e66'),
        'access_token' => getenv('FACEBOOK_ACCESS_TOKEN', 'EAAIT7LwYQAABAFEK0wV0YqQYTR9atKPXZBZA99RvQUmXpwZBvHZAcZAx22g9H4n9u6QXobzeKKfOd32wxThVPEBeZBUHUXhWMnezd4WWCz2b5pEXPvKD6Yq5xhZCCPz4jBvdQGOEMz7Qq2st3QQXg6TzBfchXEpPkehCaIinn5ZCaoiJZBeseF8qOMFugzdEPCNmsGBT7XaLdWAZDZD'),
    ],

    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID', '10162817087695634'),
        'client_id' => env('FACEBOOK_CLIENT_ID', '10162817087695634'),         // Your Facebook App Client ID
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', 'd8cffd5f033b81df8a9d9845c3528e66'), // Your Facebook App Client Secret
        'redirect' => env('FACEBOOK_REDIRECT', 'https://'.env('APP_URL').'/login/facebook/callback'), // Your application route used to redirect users back to your app after authentication
        'default_graph_version' => 'v2.5',
    ],
];
