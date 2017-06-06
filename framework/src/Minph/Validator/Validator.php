<?php

namespace Minph\Validator;

class Validator
{
    public function __construct()
    {
    }

    public function validate(array $data, array $rules)
    {
        $errors = [];
        foreach ($rules as $key => $rule) {
            if (isset($data[$key])) {
                $tmp = explode('|', $rule);
                $ret = $this->callFunctionFromString($tmp[0], $data[$key]);
                if (!$ret) {
                    $errors[$key] = $tmp[1];
                }
            }
        }
        return $errors;
    }

    public function validateNull(string $value, array $args = null)
    {
        return $value && trim($value) !== '';
    }


    public function validateLength(string $value, array $args = null)
    {
        if ($value) {
            $len = mb_strlen(trim($value));
            $min = $args[0];
            $max = $args[1];
            if ($max == 'PHP_INT_MAX') {
                $max = PHP_INT_MAX;
            }
            $ret = $len >= $min && $len <= $max;
            return $ret;
        } else {
            return false;
        }
    }

    private function callFunctionFromString(string $func, string $value)
    {
        if (trim($func) === '') {
            return true;
        }

        $args = [];
        $matches = null;
        preg_match('/\(.*\)/', $func, $matches);
        if ($matches && isset($matches[0])) {
            $args = explode(',', trim($matches[0], "\x28\x29"));
        }

        $pos = strpos($func, '(');
        if ($pos === false) {
            $function = $func;
        } else {
            $function = trim(substr($func, 0, $pos));
        }
        return $this->{$function}($value, $args);
    }

}
