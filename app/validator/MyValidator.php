<?php


use Minph\Validator\Validator;


class MyValidator extends Validator
{

    public function validatePassword($key, $message)
    {
        $ret = false;
        if (isset($this->data[$key])) {
            $value = $this->data[$key];
            if (preg_match('/[\W]+/', $value)) {
                $ret = true;
            }
        }

        if ($ret === false) {
            $this->errors[$key] = $message;
        }
    }

    public function validateEmail($key, $message)
    {
        $ret = false;
        if (isset($this->data[$key])) {
            $value = $this->data[$key];
            $ret = filter_var($value, FILTER_VALIDATE_EMAIL);
        }

        if ($ret === false) {
            $this->errors[$key] = $message;
        }
    }
}
