<?php

require_once __DIR__ . '/bootForTest.php';

use PHPUnit\Framework\TestCase;
use Minph\Crypt\Validator;


class ValidatorTest extends TestCase
{
    public function setup()
    {
    }

    public function testValidation()
    {
        $validator = new Validator;

        $data = [
            'inputName' => 'Test name',
            'inputPass' => ' ',
            'inputTest' => ' '
        ];

        $rules = [
            'inputName' => 'validateLength(1,9)|The length of inputName is between 1 and 9',
            'inputPass' => 'validateNull()|password is required',
            'inputTest' => ''
        ];

        $errors = $validator->validate($data, $rules);

        var_dump($errors);
    }
}
