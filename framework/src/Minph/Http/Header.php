<?php

namespace Minph\Http;

if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = '';
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


class Header
{
    static $data;

    public static function init()
    {
        self::$data = [];
        $headers = getallheaders();
        if ($headers) {
            foreach ($headers as $name => $value) {
                self::$data[$name] = $value;
            }
        }
    }

    public static function get($key, $required = false)
    {
        if (array_key_exists($key, self::$data)) {
            return self::$data[$key];
        } else if ($required) {
            throw new InputException('key "' . $key . '" is required');
        } else {
            return null;
        }
    }

    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
