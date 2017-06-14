<?php

namespace Minph\Http;

use Minph\Exception\InputException;

/**
 * @function getallheaders
 *
 * This is used when getallheaders function doesn't exist. (Nginx, etc.)
 */
if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = [];
        if ($_SERVER) {
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
        }
        return $headers;
    }
}


/**
 * @class Minph\Http\Header
 *
 * Header utility class.
 */
class Header
{

    /**
     * @method (static) getMethod
     * @return string get http method
     */
    public static function method()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            return $_SERVER['REQUEST_METHOD'];
        }
        return 'UNKNOWN';
    }

    /**
     * @method (static) getHeaders
     * @return array header information
     */
    public static function get()
    {
        $data = [];
        $headers = getallheaders();
        if ($headers) {
            foreach ($headers as $name => $value) {
                $data[$name] = $value;
            }
        }
        return $data;
    }
}
