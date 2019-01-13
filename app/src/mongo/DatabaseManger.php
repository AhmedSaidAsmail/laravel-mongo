<?php

namespace Matrix\MongoDb;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use Matrix\MongoDb\Connector\ConnectionFactory;


class DatabaseManger
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;
    /**
     * The database connection factory instance.
     *
     * @var ConnectionFactory $factory
     */
    protected $factory;
    /**
     * Connection instance
     *
     * @var Connection|null
     */
    protected $connection = null;

    /**
     * DatabaseManger constructor.
     * @param \Illuminate\Foundation\Application $app
     * @param ConnectionFactory $factory
     */
    public function __construct($app, ConnectionFactory $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
    }

    public function connection()
    {
        if (is_null($this->connection)) {
            $this->connection = $this->makeConnection();

        }
        return $this->connection;

    }

    private function makeConnection()
    {
        $config = $this->getConfig();
        return $this->factory->make($config);
    }

    private function getConfig()
    {
        $name = "mongodb";
        $connections = $this->app['config']['database.connections'];
        if (is_null($config = Arr::get($connections, $name))) {
            throw new InvalidArgumentException("Database [$name] not configured.");
        }

        return $config;

    }

}