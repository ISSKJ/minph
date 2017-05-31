<?php

namespace Minph\Repository;

class Pool
{
    private static $pool = [];

    private function __construct()
    {
    }

    public static function clear()
    {
        self::$pool = [];
    }

    public static function set(string $alias, $obj)
    {
        if (self::exists($alias)) {
            return;
        }
        self::$pool[$alias] = $obj;
    }

    public static function exists(string $alias)
    {
        return array_key_exists($alias, self::$pool);
    }

    public static function get(string $alias)
    {
        return self::$pool[$alias];
    }
}
