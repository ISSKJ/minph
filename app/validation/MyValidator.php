<?php

use Minph\Validator\Validator;

class MyValidator extends Validator
{
    public function validateEmail(string $value, array $args = null)
    {
        return true;
    }

}
