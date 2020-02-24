<?php

namespace Astrotomic\LaravelGuzzle;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class GuzzleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('guzzle.php'),
            ], 'config');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'guzzle');

        $this->app->singleton(Factory::class);

        $this->app->bind(
            GuzzleClient::class,
            static function (Container $app): GuzzleClient {
                return $app->make(Factory::class)->client();
            }
        );

        $this->app->alias(GuzzleClient::class, GuzzleClientContract::class);
    }
}
