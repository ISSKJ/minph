<?php

namespace Minph\Localization;


/**
 * @class Minph\Localization\LocaleMap
 *
 * Locale mapping class.
 */
class LocaleMap
{
    private $map;

    public function __construct($path)
    {
        $this->map = include $path;
    }

    /**
     * @method gettext
     * @param string `$key`
     * @return string mapped value
     */
    public function gettext($key)
    {
        return $this->map[$key];
    }
}
