<?php

namespace Astrotomic\LaravelGuzzle;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class LaravelGuzzleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('guzzle.php'),
            ], 'config');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'guzzle');

        $this->app->bind(
            GuzzleClientContract::class,
            static function (Container $app, array $config): GuzzleClientContract {
                return new GuzzleClient(array_merge(
                    $app->make('config')->get('guzzle.default_config', []),
                    $config
                ));
            }
        );

        $this->app->alias(GuzzleClientContract::class, GuzzleClient::class);
    }
}
