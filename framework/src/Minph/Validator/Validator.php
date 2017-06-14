<?php

namespace Minph\Validator;

/**
 * @class Minph\Validator\Validator
 */
class Validator
{
    protected $errors = [];

    protected $data = [];


    /**
     * @method setData
     * @param array `$data`
     *
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @method validateNull
     * @param string `$key`
     * @param string `$message`
     *
     * Validate null and store an error if invalid.
     */
    public function validateNull($key, $message)
    {
        $ret = false;
        if (isset($this->data[$key])) {
            $value = $this->data[$key];
            $ret = $value && trim($value) !== '';
        }
        if ($ret === false) {
            $this->errors[$key] = $message;
        }
    }

    /**
     * @method validateLength
     * @param string `$key`
     * @param int `$min`
     * @param int `$max`
     *
     * Validate value's range and store an error if invalid.
     */
    public function validateLength($key, $min, $max, $message)
    {
        $ret = false;
        if (isset($this->data[$key])) {
            $value = $this->data[$key];
            $len = mb_strlen(trim($value));
            $ret = $len >= $min && $len <= $max;
        } else {
            $ret = false;
        }
        if ($ret === false) {
            $this->errors[$key] = $message;
        }
    }

    /**
     * @method getErrors
     * @return array errors
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
