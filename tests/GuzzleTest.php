<?php

namespace Astrotomic\LaravelGuzzle\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientContract;
use GuzzleHttp\RequestOptions;

final class GuzzleTest extends TestCase
{
    /** @test */
    public function it_resolves_interface_binding(): void
    {
        $guzzle = $this->app->make(GuzzleClientContract::class);

        static::assertInstanceOf(GuzzleClient::class, $guzzle);
        static::assertSame(5, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(1, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertTrue($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertTrue($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }

    /** @test */
    public function it_resolves_concrete_alias(): void
    {
        $guzzle = $this->app->make(GuzzleClientContract::class);

        static::assertInstanceOf(GuzzleClient::class, $guzzle);
        static::assertSame(5, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(1, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertTrue($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertTrue($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }
}
