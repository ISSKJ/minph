<?php

namespace Minph\Event;

class Event
{
    public static function fire($className, $tag = null)
    {
        if (!defined('APP_DIR')) {
            throw Exception('APP_DIR constant should be defined');
        }
        require_once APP_DIR . '/event/' . $className . '.php';
        $handler = new $className;
        if ($handler instanceof EventHandler) {
            $handler->handle($tag);
        }
    }
}
