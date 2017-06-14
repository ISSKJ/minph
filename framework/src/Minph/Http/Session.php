<?php

namespace Minph\Http;

use Minph\App;
use Tracy\Debugger;

/**
 * @class Minph\Http\Session
 *
 * Session utility class.
 */
class Session
{


    /**
     * @method (static) init
     *
     * [SESSION_EXPIRATION] in .env is configured.(default=`60*60`)  
     * [SERVER_SESSION_EXPIRATION] in .env is configured.(default=`60*60`)
     */
    public static function init()
    {
        $serverExpiration = App::env('SERVER_SESSION_EXPIRATION', 60*60);
        ini_set('session.gc_maxlifetime', $serverExpiration);
        session_set_cookie_params(self::getExpiration());
        session_start();
    }

    /**
     * @method (static) getExpiration
     * @return int expiration in second
     */
    public static function getExpiration()
    {
        return App::env('SESSION_EXPIRATION', 60*60);
    }

    /**
     * @method (static) get
     * @param string `$key`
     * @return session value
     */
    public static function get($key)
    {
        $now = time();
        if (isset($_SESSION['last_activity']) && 
            ($now - $_SESSION['last_activity']) > self::getExpiration()) {
            self::destroy();
        }
        $_SESSION['last_activity'] = $now;
        if (self::has($key)) {
            return $_SESSION[$key];
        }
        return null;
    }

    /**
     * @method (static) has
     * @param string `$key`
     * @return boolean If session has the key, true. Otherwise, false.
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @method (static) set
     * @param string `$key`
     * @param `$value`
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @method (static) destroy
     *
     * Destroy the session.
     */
    public static function destroy()
    {
        session_unset();
        session_destroy();
        session_start();
    }
}
