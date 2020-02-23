<?php

namespace Astrotomic\LaravelGuzzle;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Factory extends Manager
{
    /**
     * The registered custom client configs.
     *
     * @var array[]
     */
    protected $registeredConfigs = [];

    public function client(?string $identifier = null): GuzzleClient
    {
        return $this->driver($identifier);
    }

    public function driver($driver = null): GuzzleClient
    {
        return parent::driver($driver);
    }

    public function getDefaultDriver(): string
    {
        return $this->config->get('guzzle.default_client');
    }

    public function register(string $identifier, array $config): self
    {
        $this->registeredConfigs[$identifier] = $config;

        return $this;
    }

    protected function createDriver($driver): GuzzleClient
    {
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        } elseif (isset($this->registeredConfigs[$driver])) {
            return new GuzzleClient(array_merge(
                $this->registeredConfigs[$driver],
                $this->config->get('guzzle.clients.'.$driver, [])
            ));
        } elseif ($this->config->has('guzzle.clients.'.$driver)) {
            return new GuzzleClient(
                $this->config->get('guzzle.clients.'.$driver)
            );
        }

        throw new InvalidArgumentException("Client [$driver] not supported.");
    }

    protected function callCustomCreator($driver): GuzzleClient
    {
        return $this->customCreators[$driver]($this->container, $this->config->get('guzzle.clients.'.$driver, []));
    }
}