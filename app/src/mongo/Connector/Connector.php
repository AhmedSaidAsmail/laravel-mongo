<?php

namespace Matrix\MongoDb\Connector;

use Illuminate\Support\Arr;
use MongoDB\Client;
use Exception;

class Connector
{
    use DetectsLostConnections;
    /**
     * @var array $uriOptions Mongodb configuration uri option
     */
    private $uriOptions = [
        'authSource' => 'admin',
        'connectTimeoutMS' => 5000
    ];
    /**
     * @var array $driverOptions Mongodb configuration driver option
     */
    private $driverOptions = [
        'typeMap' => [
            'root' => 'array',
            'document' => 'array',
            'array' => 'array',
        ],
    ];

    /**
     * @param array $config
     * @return \MongoDB\Client
     */
    public function connect(array $config)
    {
        $uriOptions = $this->getUriOptions($config);
        $driverOptions = $this->getDriverOptions($config);
        $dsn = $this->getDsn($config);
        return $this->makeConnection($dsn, $uriOptions, $driverOptions);

    }

    private function getUriOptions(array $config)
    {
        $uriOptionsStatement = $this->getUriOptionsStatement($config);
        if (!is_null(Arr::get($config, 'username'))) {
            return array_merge([
                'username' => Arr::get($config, 'username'),
                'password' => Arr::get($config, 'password')
            ], $uriOptionsStatement);
        }
        return $uriOptionsStatement;

    }

    private function getUriOptionsStatement(array $config)
    {
        return array_merge($this->uriOptions, Arr::get($config, 'uriOptions'));
    }

    private function getDriverOptions(array $config)
    {
        return array_merge($this->driverOptions, Arr::get($config, 'driverOptions'));

    }

    private function getDsn(array $config)
    {
        return sprintf('mongodb://%s:%d', Arr::get($config, 'host'), Arr::get($config, 'port'));
    }

    private function makeConnection($dsn, array $option, array $driver)
    {
        try {
            $client = $this->createMongoClient($dsn, $option, $driver);
        } catch (Exception $e) {
            $client = $this->tryAgainIfCausedByLostConnection($e, $dsn, $option, $driver);
        }
        return $client;

    }

    private function createMongoClient($dsn, array $uri, array $driver)
    {
        return new Client($dsn, $uri, $driver);
    }

    private function tryAgainIfCausedByLostConnection(Exception $e, $dsn, array $option, array $driver)
    {
        if ($this->causedByLostConnection($e)) {
            return $this->createMongoClient($dsn, $option, $driver);
        }
        throw $e;

    }

}