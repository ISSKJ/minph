<?php

namespace Minph\Http;


class Route
{
    const NOT_FOUND = 404;
    const STATUS_OK = 200;
    static $routeMap;

    public static function init($routeMap)
    {
        self::$routeMap = $routeMap;
    }

    public static function run($uri)
    {
        if (!defined('APP_DIR')) {
            throw Exception('APP_DIR constant should be defined');
        }
        $parser = parse_url($uri);
        $path = $parser['path'];
        if (!array_key_exists($path, self::$routeMap)) {
            throw new FileNotFoundException();
        }

        $route = self::$routeMap[$path];
        $split = explode('@', $route);
        if (count($split) != 2) {
            throw new FileNotFoundException();
        }

        $controllerFile = APP_DIR . '/controller/' . $split[0] . '.php';
        if (!file_exists($controllerFile)) {
            throw new FileNotFoundException();
        }
        require_once $controllerFile;
        $controller = new $split[0];
        return $controller->{$split[1]}($uri);
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        die;
    }
}
