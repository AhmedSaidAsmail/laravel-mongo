<?php

namespace Matrix\MongoDb;

use Illuminate\Support\ServiceProvider;
use Matrix\MongoDb\Connector\ConnectionFactory;

class MongoDbServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Model::setConnectionResolver($this->app['mongo.db']);
        Model::setEventDispatcher($this->app['events']);
    }

    public function register()
    {
        $this->app->singleton('mongo.db.factory', function ($app) {
            return new ConnectionFactory($app);
        });

        $this->app->singleton('mongo.db', function ($app) {
            return new DatabaseManger($app, $app['mongo.db.factory']);
        });

        $this->app->bind('mongo.db.connection', function ($app) {
            return $app['mongo.db']->connection();
        });
    }

}