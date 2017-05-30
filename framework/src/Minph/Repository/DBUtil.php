<?php

namespace Minph\Repository;

class DBUtil
{
    const SPECIAL_CHARACTERS = "!\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~";

    private function __construct()
    {
    }

    public static function validInput(string $input, string $permission)
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
