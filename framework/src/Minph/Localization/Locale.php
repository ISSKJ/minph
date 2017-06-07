<?php

namespace Minph\Localization;

/**
 * @class Minph\Localization\Locale
 *
 * Locale configuration class.
 */
class Locale
{
    private $lang = '/en';
    private $map = [];

    private $localeMap;

    /**
     * @method construct
     *
     * Load `$appDirectory/locales.php`
     * Default lang is `/en`
     */
    public function __construct()
    {
        $this->localeMap = require_once APP_DIR .'/locales.php';
    }


    /**
     * @method trimLocalePath
     * @param string `$path`
     * @return string trimmed path 
     *
     * For example, if `$path` is "/en/user", it sets "/en" to lang and returns "/user".
     */
    public function trimLocalePath($path)
    {
        foreach ($this->localeMap as $locale => $localePath) {
            if (strpos($path, $locale) === 0) {
                $this->lang = $locale;
                $path = substr($path, 3);
                if ($path === '') {
                    $path = '/';
                }
                break;
            }
        }
        return $path;
    }

    /**
     * @method hasMap
     * @return boolean If a mapping file is loaded, true. Otherwise, false.
     */
    public function hasMap()
    {
        return !empty($this->map);
    }

    /**
     * @method getMap
     * @return array mapping file.
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @method loadMap
     * @param string `$filename` mapping file
     *
     * Load mapping file in `$appDirectory/locale/$lang/$filename`.
     */
    public function loadMap($filename)
    {
        $path = APP_DIR .'/locale/' .trim($this->lang, "\x2F") .'/' .$filename;
        if (file_exists($path)) {
            $this->map = include $path;
        }
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

