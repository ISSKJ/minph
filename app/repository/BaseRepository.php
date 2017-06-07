<?php

use Minph\Utility\Pool;
use Minph\Repository\DB;
use Minph\App;

class BaseRepository
{
    public function __construct()
    {
        if (!Pool::exists('default')) {
            $db = new DB(
                App::env('DATABASE_DSN'),
                App::env('DATABASE_USERNAME'),
                App::env('DATABASE_PASSWORD'));
            Pool::set('default', $db);
        }
    }

    public function create($table, array $input)
    {
        $db = Pool::get('default');
        return $db->insert($table, $input);
    }

    public function delete($table, $idColumn, $id)
    {
        $db = Pool::get('default');
        return $db->delete($table, $idColumn, $id);
    }
}
