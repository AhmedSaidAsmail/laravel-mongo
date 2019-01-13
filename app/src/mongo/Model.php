<?php

namespace Matrix\MongoDb;

use Illuminate\Contracts\Events\Dispatcher;

class Model
{
    /**
     * The database manager instance.
     *
     * @var DatabaseManger $databaseManger
     */
    protected static $databaseManger;
    /**
     * The event dispatcher instance.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected static $dispatcher;

    public static function setConnectionResolver(DatabaseManger $manger)
    {
        static::$databaseManger = $manger;

    }

    /**
     * Set the event dispatcher instance.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $dispatcher
     * @return void
     */
    public static function setEventDispatcher(Dispatcher $dispatcher)
    {
        static::$dispatcher = $dispatcher;
    }


}