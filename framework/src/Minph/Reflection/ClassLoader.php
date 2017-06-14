<?php

namespace Minph\Reflection;

use Minph\Exception\FileNotFoundException;


/**
 * @class Minph\Reflection\ClassLoader
 *
 * Class loader utility.
 */
class ClassLoader
{

    private function __construct()
    {
    }

    /**
     * @method (static) loadClass
     * @param string `$dirPath` directory path in `$appDirectory`
     * @param string `$className` class name
     * @return object instance of the class
     */
    public static function loadClass($dirPath, $className)
    {
        $path = APP_DIR;
        if ($dirPath) {
            // \x2F : "/"(directory separator) in ASCII
            $path .= '/' .trim($dirPath, "\x2F");
        }
        $path .= '/' .$className .'.php';

        if (!file_exists($path)) {
            throw new FileNotFoundException("not found: $path");
        }

        require_once $path;
        return new $className;
    }
}
