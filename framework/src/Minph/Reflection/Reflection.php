<?php

namespace Minph\Reflection;


class Reflection
{
    static $loadedClasses = [];


    private function __construct()
    {
    }

    public static function loadClass($dirPath, $className)
    {
        $path = APP_DIR;
        if ($dirPath) {
            $path .= '/' .trim($dirPath, "\x2F");
        }
        $path .= '/' .$className .'.php';

        if (!file_exists($path)) {
            throw new FileNotFoundException("not found: $path");
        }

        if (array_key_exists($path, self::$loadedClasses)) {
            return self::$loadedClasses[$path];
        }

        require_once $path;
        self::$loadedClasses[$path] = new $className;
        return self::$loadedClasses[$path];
    }
}
