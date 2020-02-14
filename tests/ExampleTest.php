<?php

namespace Astrotomic\LaravelGuzzle\Tests;

use Orchestra\Testbench\TestCase;
use Astrotomic\LaravelGuzzle\LaravelGuzzleServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelGuzzleServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
