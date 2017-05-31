<?php

use Minph\Repository\Pool;
use Minph\Repository\DB;

class BaseRepository
{
    public function __construct()
    {
        if (!Pool::exists('default')) {
            $db = new DB(getenv('DATABASE_DSN'), getenv('DATABASE_USERNAME'), getenv('DATABASE_PASSWORD'));
            Pool::set('default', $db);
        }
    }

    public function create(string $table, array $input)
    {
        $db = Pool::get('default');
        return $db->insert($table, $input);
    }

    public function delete(string $table, string $idColumn, int $id)
    {
        $db = Pool::get('default');
        return $db->delete($table, $idColumn, $id);
    }
}
