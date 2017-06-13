<?php

namespace Minph\Event;

use Minph\Exception\MinphException;
use Minph\Reflection\ClassLoader;

/**
 * @class Minph\Event\Event
 */
class Event
{
    /**
     * @method (static) fire
     * @param string `$className` class name
     * @param `$tag`(default = null) optional argument
     * @return `$handle` response
     *
     * `$appDirectory/event/$className.php` would be fired.
     * Event class should implements `EventHandler` interface.
     */
    public static function fire($className, $tag = null)
    {
        if (!defined('APP_DIR')) {
            throw new MinphException('APP_DIR constant should be defined');
        }
        $handler = ClassLoader::loadClass('event', $className);
        if ($handler instanceof EventHandler) {
            return $handler->handle($tag);
        }
    }
}
