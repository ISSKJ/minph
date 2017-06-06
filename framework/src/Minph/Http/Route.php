<?php

namespace Minph\Http;

use Minph\Reflection\Reflection;

class Route
{
    private function __construct()
    {
    }

    static $map;

    public static function init()
    {
        if (!defined('APP_DIR')) {
            throw Exception('APP_DIR constant should be defined');
        }

        $path = APP_DIR .'/routes.php';
        if (file_exists($path)) {
            self::$map = require_once $path;
        }
    }

    public static function run($uri, $tag = null)
    {
        if (!defined('APP_DIR')) {
            throw Exception('APP_DIR constant should be defined');
        }

        $parser = parse_url($uri);
        $path = $parser['path'];
        if (!array_key_exists($path, self::$map)) {
            throw new FileNotFoundException("path not found.");
        }

        $route = self::$map[$path];
        $split = explode('@', $route);
        if (count($split) != 2) {
            throw new FileNotFoundException();
        }

        $class = $split[0];
        $method = $split[1];

        $obj = Reflection::loadClass('controller', $class);
        return $obj->{$method}($uri, $tag);
    }

    public static function redirect($url, $status = 303)
    {
        header('Location: ' . $url, true, $status);
        die;
    }
}
