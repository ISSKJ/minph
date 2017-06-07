<?php

use Minph\Validator\Validator;

class MyValidator extends Validator
{
    public function validateEmail($value, array $args = null)
    {
        return true;
    }

}
