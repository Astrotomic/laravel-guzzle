<?php

use GuzzleHttp\ClientInterface as GuzzleClientContract;
use Psr\Http\Message\UriInterface;

if (! function_exists('guzzle')) {
    /**
     * @param string|UriInterface $baseUri
     * @param array $config
     *
     * @return GuzzleClientContract
     */
    function guzzle($baseUri = null, array $config = []): GuzzleClientContract
    {
        if ($baseUri !== null) {
            $config['base_uri'] = $baseUri;
        }

        return app(GuzzleClientContract::class, $config);
    }
}
