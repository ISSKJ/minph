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
 * It contains header information and HTTP method.
 */
class Header
{
    private $data = [];

    private $method;

    /**
     * @method construct
     */
    public function __construct()
    {
        $headers = getallheaders();
        if ($headers) {
            foreach ($headers as $name => $value) {
                $this->data[$name] = $value;
            }
        }
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->method = $_SERVER['REQUEST_METHOD'];
        }
    }

    /**
     * @method get
     * @param string `$key`
     * @param boolean `$required`
     * @throws `Minph\Exception\InputException` If `$required` is true and a value doesn't exist, it occurs.
     * @return string header value
     *
     */
    public function get($key, $required = false)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else if ($required) {
            throw new InputException('key "' . $key . '" is required');
        } else {
            return null;
        }
    }

    /**
     * @method getAll
     * @return array all the values
     */
    public function getAll()
    {
        return $this->data;
    }

    /**
     * @method getMethod
     * @return string HTTP method. 
     */
    public function getMethod()
    {
        return $this->method;
    }
}
