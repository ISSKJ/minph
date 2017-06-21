<?php

namespace Minph\Localization;

/**
 * @class Minph\Localization\Locale
 *
 * Locale configuration class.
 */
class Locale
{
    private static $lang = '/en';
    private static $localeMap;

    /**
     * @method (static) init
     *
     * Load `$appDirectory/locales.php`
     * Default lang is `/en`
     */
    public static function init()
    {
        self::$localeMap = require_once APP_DIR .'/locales.php';
    }


    /**
     * @method (static) trimLocalePath
     * @param string `$path`
     * @return string trimmed path 
     *
     * For example, if `$path` is "/en/user", it sets "/en" to lang and returns "/user".
     */
    public static function trimLocalePath($path)
    {
        foreach (self::$localeMap as $locale => $localePath) {
            if (strpos($path, $locale) === 0) {
                self::$lang = $locale;
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
    public static function hasMap()
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
     * Load mapping class in `$appDirectory/locale/$lang/$filename`.
     */
    public static function loadMap($filename)
    {
        $path = APP_DIR .'/locale/' .trim(self::$lang, "\x2F") .'/' .$filename;
        if (file_exists($path)) {
            return new LocaleMap($path);
        }
        return null;
    }
}

