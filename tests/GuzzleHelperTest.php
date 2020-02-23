<?php

namespace Astrotomic\LaravelGuzzle\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;

final class GuzzleHelperTest extends TestCase
{
    /** @test */
    public function it_resolves_helper(): void
    {
        static::assertInstanceOf(GuzzleClient::class, guzzle());
    }

    /** @test */
    public function it_receives_default_config(): void
    {
        $guzzle = guzzle();

        static::assertInstanceOf(GuzzleClient::class, $guzzle);
        static::assertSame(5, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(1, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertTrue($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertTrue($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }
}
