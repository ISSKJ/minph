<?php

namespace Minph\Http;

use Minph\Reflection\ClassLoader;
use Minph\Exception\MinphException;
use Minph\Exception\FileNotFoundException;
use Minph\Localization\Locale;
use Minph\Http\Header;
use Minph\Http\Input;


/**
 * @class Minph\Http\Route
 *
 * It is used for routing a controller by `$appDirectory/routes.php`
 */
class Route
{
    private static $map;

    /**
     * @method (static) init
     */
    public static function init()
    {
        $path = APP_DIR .'/routes.php';
        if (file_exists($path)) {
            self::$map = require_once $path;
        }
    }

    /**
     * @method (static) run
     * @param string `$uri` request URI
     * @param `$tag` an optional argument
     * @return "controller's response"
     *
     * It executes an specified controller method by `$appDirectory/routes.php`.
     */
    public static function run($uri, $tag = null)
    {
        $parser = parse_url($uri);
        $path = $parser['path'];
        $path = Locale::trimLocalePath($path);

        if (!array_key_exists($path, self::$map)) {
            throw new FileNotFoundException();
        }

        $route = self::$map[$path];
        $split = explode('@', $route);
        if (count($split) != 2) {
            throw new FileNotFoundException();
        }

        $class = $split[0];
        $method = $split[1];

        $request = [
            'uri' => $uri,
            'method' => Header::method(),
            'header' => Header::get(),
            'input' => Input::get()
        ];

        $obj = ClassLoader::loadClass('controller', $class);
        return $obj->{$method}($request, $tag);
    }

    /**
     * @method (static) redirect
     * @param string `$url` redirect URL
     * @param int `$status` (default=303) redirect status code
     *
     * It redirects to the specified URL with status code.
     */
    public static function redirect($url, $status = 303)
    {
        header('Location: ' . $url, true, $status);
        die;
    }

}
