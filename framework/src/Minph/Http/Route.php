<?php

namespace Minph\Http;

use Minph\Reflection\ClassLoader;
use Minph\Exception\MinphException;
use Minph\Exception\FileNotFoundException;
use Minph\Utility\Pool;


/**
 * @class Minph\Http\Route
 *
 * It is used for routing a controller by `$appDirectory/routes.php`
 */
class Route
{
    private $map;

    /**
     * @method construct
     */
    public function __construct()
    {
        if (!defined('APP_DIR')) {
            throw new MinphException('APP_DIR constant should be defined');
        }

        $path = APP_DIR .'/routes.php';
        if (file_exists($path)) {
            $this->map = require_once $path;
        }
    }

    /**
     * @method run
     * @param string `$uri` request URI
     * @param `$tag` an optional argument
     * @return "controller's response"
     *
     * It executes an specified controller method by `$appDirectory/routes.php`.
     */
    public function run($uri, $tag = null)
    {
        if (!defined('APP_DIR')) {
            throw new MinphException('APP_DIR constant should be defined');
        }

        $parser = parse_url($uri);
        $path = $parser['path'];
        $path = Pool::get('locale')->trimLocalePath($path);

        if (!array_key_exists($path, $this->map)) {
            throw new FileNotFoundException("path not found.");
        }

        $route = $this->map[$path];
        $split = explode('@', $route);
        if (count($split) != 2) {
            throw new FileNotFoundException();
        }

        $class = $split[0];
        $method = $split[1];

        $obj = ClassLoader::loadClass('controller', $class);
        return $obj->{$method}($uri, $tag);
    }

    /**
     * @method redirect
     * @param string `$url` redirect URL
     * @param int `$status` (default=303) redirect status code
     *
     * It redirects to the specified URL with status code.
     */
    public function redirect($url, $status = 303)
    {
        header('Location: ' . $url, true, $status);
        die;
    }

}
