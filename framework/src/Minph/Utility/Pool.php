<?php

namespace Minph\Utility;

/**
 * @class Minph\Utility\Pool
 */
class Pool
{
    private static $pool = [];

    private function __construct()
    {
    }

    /**
     * @method (static) clear
     */
    public static function clear()
    {
        self::$pool = [];
    }

    /**
     * @method (static) set
     * @param string `$alias`
     * @param object `$object`
     */
    public static function set($alias, $object)
    {
        if (self::exists($alias)) {
            return;
        }
        self::$pool[$alias] = $object;
    }

    /**
     * @method (static) exists
     * @param string `$alias`
     * @return boolean If `$alias` exists in `Pool`, true. Otherwise, false.
     */
    public static function exists($alias)
    {
        return array_key_exists($alias, self::$pool);
    }

    /**
     * @method (static) get
     * @param string `$alias`
     * @return object `$object`
     */
    public static function get($alias)
    {
        return self::$pool[$alias];
    }

    /**
     * @method (static) remove
     * @param string `$alias`
     */
    public static function remove($alias)
    {
        unset(self::$pool[$alias]);
    }
}
