# Laravel Guzzle HTTP

[![Latest Version](http://img.shields.io/packagist/v/astrotomic/laravel-guzzle.svg?label=Release&style=for-the-badge)](https://packagist.org/packages/astrotomic/laravel-guzzle)
[![MIT License](https://img.shields.io/github/license/Astrotomic/laravel-guzzle.svg?label=License&color=blue&style=for-the-badge)](https://github.com/Astrotomic/laravel-guzzle/blob/master/LICENSE)
[![Offset Earth](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-green?style=for-the-badge)](https://plant.treeware.earth/Astrotomic/laravel-guzzle)

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/Astrotomic/laravel-guzzle/run-tests?style=flat-square&logoColor=white&logo=github&label=Tests)](https://github.com/Astrotomic/laravel-guzzle/actions?query=workflow%3Arun-tests)
[![StyleCI](https://styleci.io/repos/240394430/shield)](https://styleci.io/repos/240394430)
[![Total Downloads](https://img.shields.io/packagist/dt/astrotomic/laravel-guzzle.svg?label=Downloads&style=flat-square)](https://packagist.org/packages/astrotomic/laravel-guzzle)

This is a simple wrapper for Laravel around `guzzlehttp/guzzle`. It provides container bindings and a little helper function.
The idea was born by reading [Always set a timeout for Guzzle requests inside a queued job](https://divinglaravel.com/always-set-a-timeout-for-guzzle-requests-inside-a-queued-job) by [@themsaid](https://twitter.com/themsaid).
Why limit it to the queue? At the end the problem applies to **every** curl request.
That's why this package comes with a default config which is applied to every guzzle instance build by this package.

## Installation

You can install the package via composer:

```bash
composer require astrotomic/laravel-guzzle
```

After this you should publish the package config and adjust it to your needs.

```bash
php artisan vendor:publish --provider="Astrotomic\LaravelGuzzle\LaravelGuzzleServiceProvider" --tag=config
```

## Usage

The core of this package is the `\Astrotomic\LaravelGuzzle\Factory` which can handle multiple guzzle clients.
There's also a facade that forwards calls to the factory.

```php
use Astrotomic\LaravelGuzzle\Facades\Guzzle;
use Psr\Http\Message\ResponseInterface;

/** @var ResponseInterface $response */
$response = Guzzle::client('jsonplaceholder')->get('posts/1');
$response->getStatusCode(); // 200
```

### Default Client

By default the `default_client` config refers to a `default` client.
The `clients` config key holds all client specific configs.
For all possible request options please refer to the [official guzzle docs](http://docs.guzzlephp.org/en/stable/request-options.html).

### new Clients

There are multiple ways to register a new client - the easiest would be to simply add a new config to the `clients` config key.
This will also be the most common for users using the package in a Laravel app.

#### Register config

If you want to configure your clients from within a service provider you can use the `\Astrotomic\LaravelGuzzle\Factory::register()` method.
The registered config will be merged with an optional app config.
This will also come in handy for package developers who want to allow the fin al user to customize the guzzle config.

```php
use Astrotomic\LaravelGuzzle\Facades\Guzzle;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\RequestOptions;

class HttpServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Guzzle::register('jsonplaceholder', [
            'base_uri' => 'https://jsonplaceholder.typicode.com',
            RequestOptions::TIMEOUT => 3,
        ]);
    }
}
```

#### Register Creator

If you have the need to create a real `GuzzleHttp\Client` instance yourself you can do so and assign it to an identifier.
This way you can also use a custom client class - the only requirement is that it extends the basic `GuzzleHttp\Client` class.

```php
use Astrotomic\LaravelGuzzle\Facades\Guzzle;
use GuzzleHttp\Client;
use Illuminate\Contracts\Container\Container;

Guzzle::extend('astrotomic', static function (Container $app, ?array $config): Client {
    return new Client(array_merge([
        'base_uri' => 'https://astrotomic.info',
    ], $config));
});
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email dev.gummibeer@gmail.com instead of using the issue tracker.

## Credits

- [Tom Witkowski](https://github.com/Gummibeer)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment I would highly appreciate you buying the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to [plant trees](https://www.bbc.co.uk/news/science-environment-48870920). If you contribute to my forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees at [offset.earth/treeware](https://plant.treeware.earth/Astrotomic/laravel-guzzle)

Read more about Treeware at [treeware.earth](https://treeware.earth)
