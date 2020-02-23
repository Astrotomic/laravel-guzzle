<?php

use GuzzleHttp\RequestOptions;

return [
    'default_client' => 'default',

    'clients' => [
        'default' => [
            RequestOptions::TIMEOUT => 5,
            RequestOptions::CONNECT_TIMEOUT => 1,
            RequestOptions::HTTP_ERRORS => true,
            RequestOptions::ALLOW_REDIRECTS => true,
        ],
    ],
];
