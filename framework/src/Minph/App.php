<?php


namespace Minph;

use Minph\Http\Header;
use Minph\Http\Input;
use Minph\Http\Route;
use Minph\Event\Event;
use Minph\Repository\Pool;
use Minph\Http\FileNotFoundException;
use Minph\Http\Session;
use Minph\View\View;
use Minph\View\Template;
use Minph\Reflection\Reflection;

use \Dotenv\Dotenv;
use \Tracy\Debugger;

class App
{
    public static function init($appDir)
    {
        $file = $appDir .'/.env';
        if (!file_exists($file)) {
            throw new FileNotFoundException("file not found: $file");
        }

        define('APP_DIR', $appDir);

        $dotenv = new Dotenv($appDir);
        $dotenv->load();
        Input::init();
        Header::init();
        Route::init();
        Session::init();
    }

    public static function setupDebugger($function = null)
    {
        if ($function != null) {
            $function();
            return;
        }

        $dir = APP_DIR .'/storage/log';
        if (!file_exists($dir)) {
            throw new FileNotFoundException("directory not found: $dir");
        }
        if (App::env('DEBUG', 'false') === 'true') {
            Debugger::enable(Debugger::DEVELOPMENT, $dir);
        } else {
            Debugger::enable(Debugger::PRODUCTION, $dir);
        }
    }

    public static function setTemplate($templateEngine)
    {
        if ($templateEngine instanceof Template) {
            View::init($templateEngine);
        }
    }

    public static function make($dir, $class)
    {
        return Reflection::loadClass($dir, $class);
    }

    public static function env($key, $default = '')
    {
        $value = getenv($key);
        if (!$value) {
            return $default;
        }
        return $value;
    }

    public static function run($uri = '/', $function = null)
    {
        if ($function) {
            $function();
            return;
        }
        if (array_key_exists('REQUEST_URI', $_SERVER)) {
            $uri = $_SERVER['REQUEST_URI'];
        }

        $tag = null;
        try {
            $status = Route::run($uri);
        } catch (FileNotFoundException $e) {
            $status = 404;
            $tag = $e;
        }

        switch ($status) {
        case 404:
            Route::run('/404', $tag);
            break;
        default:
            break;
        }
    }
}
