<?php

namespace app\libraries;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;

class Capsule
{
    public function __construct()
    {
        require APPPATH . "config/database.php";
        $db = $db['default'];

        $capsule = new Manager;
        $capsule->addConnection(array(
            'driver'    => 'mysql',
            'host'      => $db['hostname'],
            'username'  => $db['username'],
            'password'  => $db['password'],
            'database'  => $db['database'],
            'charset'   => $db['char_set']
        ));
        $capsule->setEventDispatcher(new Dispatcher(new Container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
