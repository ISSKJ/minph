<?php


use PHPUnit\Framework\TestCase;
use Minph\Validator\Validator;


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
            'inputPass' => 'pass',
            'inputTest' => ' '
        ];

        $rules = [
            'inputName' => 'validateLength(1,9)|The length of inputName is between 1 and 9',
            'inputPass' => 'validateNull()|password is required',
            'inputTest' => ''
        ];

        $errors = $validator->validate($data, $rules);

        $this->assertEmpty($errors);
    }
}
