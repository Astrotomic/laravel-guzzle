<?php

use GuzzleHttp\RequestOptions;

return [
    'default_config' => [
        RequestOptions::TIMEOUT => 5,
        RequestOptions::CONNECT_TIMEOUT => 1,
        RequestOptions::HTTP_ERRORS => true,
        RequestOptions::ALLOW_REDIRECTS => true,
    ],
];
