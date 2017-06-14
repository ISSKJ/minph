# Validation

## Basic Validation
```
<?php
use Minph\Validator\Validator;

$validator = new Validator();

// user input
$data = $request['input'];

$validator = App::make('validator', 'MyValidator');
$validator->setData($data);
$validator->validateEmail('email', 'email is invalid');
$validator->validatePassword('password', 'password is invalid');

$errors = $validator->getErrors();

/** 
 * Sample $errors 

[
    'email'     => 'email is invalid',
    'password'  => 'password is invalid'
];
*/
```

## Custom validation
```
<?php

use Minph\Validator\Validator;

class MyValidator extends Validator
{
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
```
