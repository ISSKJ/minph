<?php


namespace Minph;

use Minph\Http\Header;
use Minph\Http\Input;
use Minph\Http\Route;
use Minph\Exception\FileNotFoundException;
use Minph\Exception\AuthException;
use Minph\Http\Session;
use Minph\View\Template;
use Minph\View\View;
use Minph\Localization\Locale;
use Minph\Reflection\ClassLoader;

use \Dotenv\Dotenv;
use \Tracy\Debugger;

/**
 * @class App
 *
 * Application static class utility.
 */
class App
{
    /**
     * @method (static) init
     * @param string `$appDir` application directory
     *
     * It initializes application settings.
     */
    public static function init($appDir)
    {
        $file = $appDir .'/.env';
        if (!file_exists($file)) {
            throw new FileNotFoundException("file not found: $file");
        }

        define('APP_DIR', $appDir);

        $dotenv = new Dotenv($appDir);
        $dotenv->load();

        Session::init();
        Locale::init();
        Route::init();
    }

    /**
     * @method (static) setupDebugger
     *
     * It sets debugger of Tracy\Debugger\Debugger library.
     */
    public static function setupDebugger($function = null)
    {
        if ($function != null) {
            call_user_func($function);
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

    /**
     * @method (static) setTemplate
     * @param object `$templateEngine`
     *
     */
    public static function setTemplate($templateEngine)
    {
        if ($templateEngine instanceof Template) {
            View::setTemplate($templateEngine);
        }
    }

    /**
     * @method (static) make
     * @param string `$dir` directory name
     * @param string `$class` class name
     * @return object class object 
     */
    public static function make($dir, $class)
    {
        return ClassLoader::loadClass($dir, $class);
    }

    /**
     * @method (static) env
     * @param string `$key`
     * @param string `$default` (default = '')
     * @return string value in `.env`.
     */
    public static function env($key, $default = '')
    {
        $value = getenv($key);
        if (!$value) {
            return $default;
        }
        return $value;
    }

    /**
     * @method (static) run
     * @param callable `$function`
     *
     * It executes an specified controller method by `$appDirectory/routes.php`.
     */
    public static function run($function = null)
    {
        $uri = '/';
        if (array_key_exists('REQUEST_URI', $_SERVER)) {
            $uri = $_SERVER['REQUEST_URI'];
        }

        if ($function) {
            call_user_func($function, $uri);
        }
    }
}
