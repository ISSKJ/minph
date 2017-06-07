<?php

namespace Minph\Utility;


/**
 * @class Minph\Utility\Number
 */
class Number
{

    private function __construct()
    {
    }

    /**
     * @method (static) toInt
     * @param `$value`
     * @param int `$default` (default = 0)
     * @return int value
     */
    public static function toInt($value, $default = 0)
    {
        if (is_numeric($value)) {
            return (int)$value;
        }
        return $default;
    }

    /**
     * @method (static) toFloat
     * @param `$value`
     * @param float `$default` (default = 0)
     * @return float value
     */
    public static function toFloat($value, $default = 0.0)
    {
        if (is_numeric($value)) {
            return (float)$value;
        }
        return $default;
    }
}
