<?php

namespace Astrotomic\LaravelGuzzle\Tests;

use Astrotomic\LaravelGuzzle\Facades\Guzzle;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientContract;
use GuzzleHttp\RequestOptions;
use Orchestra\Testbench\TestCase;
use Astrotomic\LaravelGuzzle\LaravelGuzzleServiceProvider;

final class LaravelGuzzleTest extends TestCase
{
    /** @test */
    public function it_resolves_interface_binding()
    {
        static::assertGuzzle($this->app->make(GuzzleClientContract::class));
    }

    /** @test */
    public function it_resolves_concrete_alias()
    {
        static::assertGuzzle($this->app->make(GuzzleClient::class));
    }

    /** @test */
    public function it_resolves_facade()
    {
        static::assertGuzzle(Guzzle::getFacadeRoot());
    }

    /** @test */
    public function it_resolves_helper()
    {
        static::assertGuzzle(guzzle());
    }

    /** @test */
    public function it_receives_default_config()
    {
        $guzzle = guzzle();

        static::assertGuzzle($guzzle);
        static::assertSame(5, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(1, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertTrue($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertTrue($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }

    /** @test */
    public function it_receives_customized_config()
    {
        $this->app->make('config')->set('guzzle.default_config', [
            RequestOptions::TIMEOUT => 10,
            RequestOptions::CONNECT_TIMEOUT => 3,
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::ALLOW_REDIRECTS => false,
        ]);

        $guzzle = guzzle();

        static::assertGuzzle($guzzle);
        static::assertSame(10, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(3, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertFalse($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertFalse($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }

    /** @test */
    public function helper_can_define_base_uri()
    {
        $guzzle = guzzle('https://example.com');

        static::assertGuzzle($guzzle);
        static::assertSame('https://example.com', (string) $guzzle->getConfig('base_uri'));
    }

    /** @test */
    public function helper_can_define_custom_config()
    {
        $guzzle = guzzle('https://example.com', [
            RequestOptions::CONNECT_TIMEOUT => 3,
        ]);

        static::assertGuzzle($guzzle);
        static::assertSame('https://example.com', (string) $guzzle->getConfig('base_uri'));
        static::assertSame(5, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(3, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertTrue($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertTrue($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }

    protected function getPackageProviders($app)
    {
        return [LaravelGuzzleServiceProvider::class];
    }

    private static function assertGuzzle($actual): void
    {
        static::assertInstanceOf(GuzzleClient::class, $actual);
    }
}
