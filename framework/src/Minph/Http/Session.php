<?php

namespace Minph\Http;

use Minph\App;

class Session
{

    private static $sExpiration = 0;

    public static function init()
    {
        ini_set('session.gc_maxlifetime', 3600);
        session_start();
        session_set_cookie_params(60*5);
    }

    public static function getExpiration()
    {
        if (self::$sExpiration === 0) {
            self::$sExpiration = App::env('SESSION_EXPIRATION', 60*5);
        }
        return self::$sExpiration;
    }

    public static function get($key)
    {
        $now = time();
        if (isset($_SESSION['last_activity']) && 
            ($now - $_SESSION['last_activity']) > self::getExpiration()) {
            self::destroy();
        }
        $_SESSION['last_activity'] = $now;
        return $_SESSION[$key];
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
        session_start();
    }
}
