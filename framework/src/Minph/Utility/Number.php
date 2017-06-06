<?php

namespace Minph\Utility;


class Number
{

    private function __construct()
    {
    }

    public static function toInt($val, $default = 0)
    {
        if (is_numeric($val)) {
            return (int)$val;
        }
        return $default;
    }
    public static function toFloat($val, $default = 0)
    {
        if (is_numeric($val)) {
            return (float)$val;
        }
        return $default;
    }
}
