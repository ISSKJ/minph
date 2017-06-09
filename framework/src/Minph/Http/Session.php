<?php

namespace Minph\Http;

use Minph\App;
use Tracy\Debugger;

/**
 * @class Minph\Http\Session
 *
 */
class Session
{

    private $expiration = 0;

    /**
     * @method construct
     *
     * [SESSION_EXPIRATION] in .env is configured.(default=`60*60`)  
     * [SERVER_SESSION_EXPIRATION] in .env is configured.(default=`60*60`)
     */
    public function __construct()
    {
        $serverExpiration = App::env('SERVER_SESSION_EXPIRATION', 60*60);
        ini_set('session.gc_maxlifetime', $serverExpiration);

        $this->expiration = App::env('SESSION_EXPIRATION', 60*60);
        session_set_cookie_params($this->expiration);

        session_start();
    }

    /**
     * @method getExpiration
     * @return int expiration in second
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @method get
     * @param string `$key`
     * @return session value
     */
    public function get($key)
    {
        $now = time();
        if (isset($_SESSION['last_activity']) && 
            ($now - $_SESSION['last_activity']) > $this->getExpiration()) {
            $this->destroy();
        }
        $_SESSION['last_activity'] = $now;
        return $_SESSION[$key];
    }

    /**
     * @method has
     * @param string `$key`
     * @return boolean If session has the key, true. Otherwise, false.
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @method set
     * @param string `$key`
     * @param `$value`
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @method destroy
     *
     * Destroy the session.
     */
    public function destroy()
    {
        session_unset();
        session_destroy();
        session_start();
    }
}
