# Validation

## How to validate user input

### Basic Validation
```
<?php
use Minph\Validator\Validator;

$validator = new Validator();

// user input
$data = Pool::get('input')->getAll();

$error = $validator->validate($data, [
        'inputFirstName' => 'validateLength(3, 255)|The size of first name should be between 3 and 255 letters',
        'inputLastName' => 'validateLength(3, 255)|The size of last name should be between 3 and 255 letters',
        'inputPassword' => 'validateNull()|Password is required',
        'inputConfirmPassword' => 'validateNull()|Confirm password is required',
]);

if (!empty($error)) {
    $model = [
        'error' => $error
    ];
} else {
    $model = [
    ];
}

Pool::get('view')->view('register.tpl', $model);

```

### Custom validation
```
<?php

use Minph\Validator\Validator;

class MyValidator extends Validator
{
    public function validateEmail($value, array $args = null)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
```

```
$validator = App::make('validation', 'MyValidator');
$error = $validator->validate($data, [
        'inputEmail' => 'validateEmail()|Email address is invalid.'
]);
```
