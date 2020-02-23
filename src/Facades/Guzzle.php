<?php

namespace Astrotomic\LaravelGuzzle\Facades;

use Astrotomic\LaravelGuzzle\Factory as GuzzleFactory;
use Closure;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientContract;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Facade;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * @see GuzzleFactory
 * @method static GuzzleClient make($baseUri = null, array $config = [])
 * @method static GuzzleClient client(?string $driver = null)
 * @method static GuzzleFactory extend(string $driver, Closure $callback)
 * @method static GuzzleFactory register(string $identifier, array $config)
 * @method static array getDrivers()
 *
 * @see GuzzleClientContract
 * @method static ResponseInterface send(RequestInterface $request, array $options = [])
 * @method static PromiseInterface sendAsync(RequestInterface $request, array $options = [])
 * @method static ResponseInterface request(string $method, string|UriInterface $uri, array $options = [])
 * @method static PromiseInterface requestAsync(string $method, string|UriInterface $uri, array $options = [])
 *
 * @see GuzzleClient
 * @method static ResponseInterface get(string|UriInterface $uri, array $options = [])
 * @method static ResponseInterface head(string|UriInterface $uri, array $options = [])
 * @method static ResponseInterface put(string|UriInterface $uri, array $options = [])
 * @method static ResponseInterface post(string|UriInterface $uri, array $options = [])
 * @method static ResponseInterface patch(string|UriInterface $uri, array $options = [])
 * @method static ResponseInterface delete(string|UriInterface $uri, array $options = [])
 * @method static PromiseInterface getAsync(string|UriInterface $uri, array $options = [])
 * @method static PromiseInterface headAsync(string|UriInterface $uri, array $options = [])
 * @method static PromiseInterface putAsync(string|UriInterface $uri, array $options = [])
 * @method static PromiseInterface postAsync(string|UriInterface $uri, array $options = [])
 * @method static PromiseInterface patchAsync(string|UriInterface $uri, array $options = [])
 * @method static PromiseInterface deleteAsync(string|UriInterface $uri, array $options = [])
 */
class Guzzle extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GuzzleFactory::class;
    }
}
