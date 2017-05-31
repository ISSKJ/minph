<?php

use Minph\View\View;
use Minph\Event\Event;
use Minph\App;
use Minph\Repository\DB;

class UserController
{
    public function index()
    {
        echo "<h1>It works.";
        $db = new DB(getenv('DATABASE_DSN'), getenv('DATABASE_USERNAME'), getenv('DATABASE_PASSWORD'));
        $obj = $db->queryOne('SELECT * FROM users');
        var_dump($obj);
    }
}
