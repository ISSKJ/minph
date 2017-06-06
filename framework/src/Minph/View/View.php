<?php

namespace Minph\View;

class View
{
    private static $template;

    public static function init($template)
    {
        self::$template = $template;
    }

    public static function view($file, $model = null)
    {
        if (self::$template == null) {
            throw \Exception('template engine is not set');
        }
        self::$template->view($file, $model);
    }
}

