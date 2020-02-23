<?php

use Astrotomic\LaravelGuzzle\Facades\Guzzle;
use GuzzleHttp\Client as GuzzleClient;

if (! function_exists('guzzle')) {
    /**
     * @param string|null $identifier
     *
     * @return GuzzleClient
     */
    function guzzle(?string $identifier = null): GuzzleClient
    {
        return Guzzle::client($identifier);
    }
}
