<?php

namespace Matrix\MongoDb\Connector;

use Closure;
use Exception;
use InvalidArgumentException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Matrix\MongoDb\Connection;

class ConnectionFactory
{
    /**
     * The IoC container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * Create a new connection factory instance.
     *
     * @param  \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Establish a MongoDb Client based on configuration
     *
     * @param array $config
     * @return Connection
     */

    public function make(array $config)
    {
        return $this->createSingleConnection($config);
    }

    /**
     * Creating a single database connection instance
     *
     * @param array $config
     * @return Connection
     */

    private function createSingleConnection(array $config)
    {
        $mongoClient = $this->createClientResolver($config);
        return $this->createConnection($mongoClient, $config['database']);
    }

    /**
     * Create a new Closure that resolves to a MongoDb Client instance with a specific host or an array of hosts.
     *
     * @param array $config
     * @return \Closure
     */
    private function createClientResolver(array $config)
    {

        return function () use ($config) {
            $hosts = is_array($config['host']) ? $config['host'] : [$config['host']];

            if (empty($hosts)) {
                throw new InvalidArgumentException('Mongo Database hosts array is empty.');
            }
            try {
                return (new Connector())->connect($config);

            } catch (Exception $e) {
                $this->container->make(ExceptionHandler::class)->report($e);
                throw $e;
            }
        };
    }

    private function createConnection(Closure $client, $database)
    {
        return new Connection($client(), $database);

    }

}