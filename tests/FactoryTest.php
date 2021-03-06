<?php

namespace Astrotomic\LaravelGuzzle\Tests;

use Astrotomic\LaravelGuzzle\Facades\Guzzle;
use Astrotomic\LaravelGuzzle\Factory as GuzzleFactory;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

final class FactoryTest extends TestCase
{
    /** @test */
    public function it_resolves_singleton(): void
    {
        static::assertInstanceOf(GuzzleFactory::class, $this->app->make(GuzzleFactory::class));
    }

    /** @test */
    public function it_resolves_facade(): void
    {
        static::assertInstanceOf(GuzzleFactory::class, Guzzle::getFacadeRoot());
    }

    /** @test */
    public function it_receives_default_config(): void
    {
        $guzzle = Guzzle::client();

        static::assertInstanceOf(GuzzleClient::class, $guzzle);
        static::assertSame(5, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(1, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertTrue($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertTrue($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }

    /** @test */
    public function it_can_extend_with_custom_client(): void
    {
        $this->app->make('config')->set('guzzle.clients.astrotomic', [
            RequestOptions::TIMEOUT => 3,
        ]);

        Guzzle::extend('astrotomic', static function (Container $app, ?array $config): GuzzleClient {
            return new GuzzleClient(array_merge([
                'base_uri' => 'https://astrotomic.info',
            ], $config));
        });

        $guzzle = Guzzle::client('astrotomic');

        static::assertInstanceOf(GuzzleClient::class, $guzzle);
        static::assertInstanceOf(Uri::class, $guzzle->getConfig('base_uri'));
        static::assertSame('https://astrotomic.info', (string) $guzzle->getConfig('base_uri'));
        static::assertSame(3, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(1, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertTrue($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertTrue($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }

    /** @test */
    public function it_can_register_custom_client(): void
    {
        $this->app->make('config')->set('guzzle.clients.astrotomic', [
            RequestOptions::TIMEOUT => 8,
        ]);

        Guzzle::register('astrotomic', [
            'base_uri' => 'https://astrotomic.info',
        ]);

        $guzzle = Guzzle::client('astrotomic');

        static::assertInstanceOf(GuzzleClient::class, $guzzle);
        static::assertInstanceOf(Uri::class, $guzzle->getConfig('base_uri'));
        static::assertSame('https://astrotomic.info', (string) $guzzle->getConfig('base_uri'));
        static::assertSame(8, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(1, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertTrue($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertTrue($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }

    /** @test */
    public function it_throws_exception_when_client_is_not_registered(): void
    {
        static::expectException(InvalidArgumentException::class);

        Guzzle::client('astrotomic');
    }

    /** @test */
    public function it_can_make_a_new_default_configured_client(): void
    {
        $guzzle = Guzzle::make();

        static::assertInstanceOf(GuzzleClient::class, $guzzle);
        static::assertSame(5, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(1, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertTrue($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertTrue($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }

    /** @test */
    public function it_can_make_a_new_custom_client(): void
    {
        $guzzle = Guzzle::make('https://github.com', [
            RequestOptions::TIMEOUT => 6,
        ]);

        static::assertInstanceOf(GuzzleClient::class, $guzzle);
        static::assertInstanceOf(Uri::class, $guzzle->getConfig('base_uri'));
        static::assertSame('https://github.com', (string) $guzzle->getConfig('base_uri'));
        static::assertSame(6, $guzzle->getConfig(RequestOptions::TIMEOUT));
        static::assertSame(1, $guzzle->getConfig(RequestOptions::CONNECT_TIMEOUT));
        static::assertTrue($guzzle->getConfig(RequestOptions::HTTP_ERRORS));
        static::assertTrue($guzzle->getConfig(RequestOptions::ALLOW_REDIRECTS));
    }

    /** @test */
    public function it_binds_clients_as_singleton(): void
    {
        $guzzle1 = Guzzle::client();
        $guzzle2 = Guzzle::client();

        static::assertSame($guzzle1, $guzzle2);
    }

    /** @test */
    public function it_can_call_guzzle_methods_on_default_client(): void
    {
        $response = Guzzle::get('https://astrotomic.info');

        static::assertInstanceOf(ResponseInterface::class, $response);
    }
}
