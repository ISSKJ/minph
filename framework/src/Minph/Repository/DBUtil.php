<?php

namespace Minph\Repository;

/**
 * @class Minph\Repository\DBUtil
 *
 * Database utility.
 */
class DBUtil
{
    const SPECIAL_CHARACTERS = "!\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~";

    private function __construct()
    {
    }

    /**
     * @method (static) validInput
     * @param string `$input`
     * @param string `$permission` the characters which should be skipped
     * @return boolean If the input is valid, true. Otherwise, false.
     *
     */
    public static function validInput($input, $permission)
    {
        if (!isset($input) || trim($input) === '') {
            return false;
        }
        if (!isset($permission) || trim($permission) === '') {
            return false;
        }
        $chars = preg_replace("/[$permission]/", "", self::SPECIAL_CHARACTERS);
        return strpbrk($input, $chars) === false;
    }
}
