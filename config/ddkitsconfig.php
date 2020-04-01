<?php

// By Sam Elayyoub for DDKits Facebook poster

return [
    'table_config' => [
        'dbtable' => 'feeds',
        //'enable_beta_mode' => true,
        //'http_client_handler' => 'guzzle',
    ],

    'default_scope' => [],
    'path' => 'news',
    /*
     * The default endpoint that Facebook will redirect to after
     * an authentication attempt.
     */
    'default_redirect_uri' => '/facebook/callback',
    ];
