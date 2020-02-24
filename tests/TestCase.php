<?php

namespace Astrotomic\LaravelGuzzle\Tests;

use Astrotomic\LaravelGuzzle\GuzzleServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [GuzzleServiceProvider::class];
    }
}
