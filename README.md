# Laravel Guzzle HTTP

[![Latest Version](http://img.shields.io/packagist/v/astrotomic/laravel-guzzle.svg?label=Release&style=for-the-badge)](https://packagist.org/packages/astrotomic/laravel-guzzle)
[![MIT License](https://img.shields.io/github/license/Astrotomic/laravel-guzzle.svg?label=License&color=blue&style=for-the-badge)](https://github.com/Astrotomic/laravel-guzzle/blob/master/LICENSE)
[![Offset Earth](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-green?style=for-the-badge)](https://offset.earth/treeware)

This is a simple wrapper for Laravel around `guzzlehttp/guzzle`. It provides container bindings and a little helper function.
The idea was born by reading [Always set a timeout for Guzzle requests inside a queued job](https://divinglaravel.com/always-set-a-timeout-for-guzzle-requests-inside-a-queued-job) by [@themsaid](https://twitter.com/themsaid).
Why limit it to the queue? ATt the end the problem applies to **every** curl request.
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

### Helper

You can use the helper function to create a new instance of `GuzzleHttp\Client`. The helper function has two optional arguments. The `base_uri` and a `config` array. Both are merged with the default config defined in the package config file.

```php
$guzzle = guzzle('https://example.com', [
    RequestOptions::CONNECT_TIMEOUT => 3,
]);
```

### Injection

Because this package binds the guzzle client with the container you can use injection. The only downside is that you aren't able to set a `base_uri` this way.

```php
class MyClass 
{
    public function __construct(\GuzzleHttp\ClientInterface $guzzle)
    {
        $this->guzzle = $guzzle;
    }
}
```

### Make

For sure you can also make a client via any app container.

```php
$guzzle = app(\GuzzleHttp\ClientInterface::class, [
    'base_uri' => 'https://example.com',
]);
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

You can buy trees at https://offset.earth/treeware

Read more about Treeware at https://treeware.earth

[![We offset our carbon footprint via Offset Earth](https://toolkit.offset.earth/carbonpositiveworkforce/badge/5e186e68516eb60018c5172b?black=true&landscape=true)](https://offset.earth/treeware)
