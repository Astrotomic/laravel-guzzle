<?php

namespace Astrotomic\LaravelGuzzle\Facades;

use GuzzleHttp\ClientInterface as GuzzleClientContract;
use Illuminate\Support\Facades\Facade;

class Guzzle extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GuzzleClientContract::class;
    }
}
