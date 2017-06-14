<?php

namespace Minph\View;

/**
 * @class Minph\View\View
 */
class View
{
    private static $template;

    /**
     * @method (static) setTemplate
     * @param Template template engine
     *
     */
    public static function setTemplate($template)
    {
        self::$template = $template;
    }

    /**
     * @method (static) view
     * @param string `$file` template file path in `$appDirectory/view/`.
     * @param model (default = null)
     *
     * It outputs view resource.
     */
    public static function view($file, $model = null)
    {
        return self::$template->view($file, $model);
    }
}
