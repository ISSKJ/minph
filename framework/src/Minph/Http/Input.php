<?php

namespace Minph\Http;

class Input
{
    static $data;

    public static function init()
    {
        self::$data = [];
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                self::$data[$key] = $value;
            }
        }
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                self::$data[$key] = $value;
            }
        }
        if (isset($_SERVER['CONTENT_TYPE'])) {
            self::$data['raw'] = file_get_contents('php://input');
        }
    }

    public static function remove($key)
    {
        unset(self::$data[$key]);
    }

    public static function put($key, $value)
    {
        self::$data[$key] = $value;
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

    public static function getAll()
    {
        return self::$data;
    }
}
