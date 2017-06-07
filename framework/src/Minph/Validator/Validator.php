<?php

namespace Minph\Validator;

/**
 * @class Minph\Validator\Validator
 */
class Validator
{
    /**
     * @method construct
     */
    public function __construct()
    {
    }

    /**
     * @method validate
     * @param array `$data`
     * @param array `$rules`
     * @return array errors
     *
     * `$rules` formats:
     * ```
     * '{method call}|{error message}'
     * ```
     *
     * For example,
     * ```
     * $error = $validator->validate($data, [
     *     'inputEmail' => 'validateEmail()|Email address is invalid',
     *     'inputPassword' => 'validateNull()|password is required',
     *     'inputConfirmPassword' => 'validateNull()|confirm password is required',
     * ]);
     * if (!empty($error)) {
     *     // error handling.
     *     // $error['inputPassword'];
     * }
     * ```
     */
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

    /**
     * @method validateNull
     * @param string `$value`
     * @return boolean If `$value` is not null and not empty, true. Otherwise, false.
     */
    public function validateNull($value)
    {
        return $value && trim($value) !== '';
    }

    /**
     * @method validateLength
     * @param string `$value`
     * @param array `$args` (default = null) ex. [3(min), 9(max)]
     * @return boolean If `$value` is valid length, true. Otherwise, false.
     *
     * For example,
     * ```
     * $value = 1;
     * $result = validateLength($value, [3, 9]);
     * // $result is false because $value is less than 3.
     * ```
     */
    public function validateLength($value, array $args = null)
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

    private function callFunctionFromString($func, $value)
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
