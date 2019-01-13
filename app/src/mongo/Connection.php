<?php

namespace Matrix\MongoDb;

use MongoDB\Client;

class Connection
{
    /**
     * The Active MongoDb Client used
     *
     * @var Client $client
     */
    protected $client;
    /**
     * The name of connected database
     *
     * @var string $database
     */
    protected $database;

    /**
     * Connection constructor.
     * @param Client $client
     * @param string $database
     */
    public function __construct(Client $client, $database)
    {
        $this->client = $client;
        $this->database = $database;
    }

}