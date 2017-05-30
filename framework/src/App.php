<?php


namespace Minph;

use Minph\Http\Header;
use Minph\Http\Input;
use Minph\Http\Route;
use Minph\Http\FileNotFoundException;
use Minph\View\View;
use Minph\View\Template;

use \Dotenv\Dotenv;
use \Tracy\Debugger;

class App
{
    public static function init(string $appDirectory)
    {
        define('APP_DIR', $appDirectory);
        $dotenv = new Dotenv($appDirectory, '.env');
        $dotenv->load();
        Route::init(require_once $appDirectory . '/route_map.php');

        if (getenv('DEBUG') === 'true') {
            Debugger::enable(Debugger::DEVELOPMENT, $appDirectory .'/storage/log');
        } else {
            Debugger::enable(Debugger::PRODUCTION, $appDirectory .'/storage/log');
        }

        Input::init();
        Header::init();
    }

    public static function setTemplate($templateEngine)
    {
        if ($templateEngine instanceof Template) {
            View::init($templateEngine);
        }
    }

    public static function run($uri = '/')
    {
        if (array_key_exists('REQUEST_URI', $_SERVER)) {
            $uri = $_SERVER['REQUEST_URI'];
        }

        $status = Route::run($uri);
        switch ($status) {
        case 404:
            Route::run('/404');
            break;
        default:
            break;
        }
    }

    public static function make(string $directory, string $class)
    {
        $path = APP_DIR .'/' .$directory .'/' .$class .'.php';
        if (!file_exists($path)) {
            throw new FileNotFoundException();
        }
        require_once $path;
        return new $class;
    }
}
