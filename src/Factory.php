<?php

namespace Astrotomic\LaravelGuzzle;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Manager;
use InvalidArgumentException;
use Psr\Http\Message\UriInterface;

class Factory extends Manager
{
    /**
     * The registered custom client configs.
     *
     * @var array[]
     */
    protected $registeredConfigs = [];

    /**
     * @param string|UriInterface|null $baseUri
     * @param array $config
     *
     * @return GuzzleClient
     */
    public function make($baseUri = null, array $config = []): GuzzleClient
    {
        if ($baseUri !== null) {
            $config['base_uri'] = $baseUri;
        }

        return $this->createClient($config);
    }

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
            return $this->createClient(array_merge(
                $this->registeredConfigs[$driver],
                $this->config->get('guzzle.clients.'.$driver, [])
            ));
        } elseif ($this->config->has('guzzle.clients.'.$driver)) {
            return $this->createClient(
                $this->config->get('guzzle.clients.'.$driver)
            );
        }

        throw new InvalidArgumentException("Client [$driver] not supported.");
    }

    protected function callCustomCreator($driver): GuzzleClient
    {
        return $this->customCreators[$driver](
            $this->container,
            $this->prepareConfig($this->config->get('guzzle.clients.'.$driver, []))
        );
    }

    protected function prepareConfig(array $config): array
    {
        return array_merge(
            $this->config->get('guzzle.default_config', []),
            $config
        );
    }

    protected function createClient(array $config): GuzzleClient
    {
        return new GuzzleClient($this->prepareConfig($config));
    }
}
