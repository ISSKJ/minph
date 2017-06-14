<?php


use PHPUnit\Framework\TestCase;
use Minph\Validator\Validator;


class ValidatorTest extends TestCase
{
    public function setup()
    {
    }

    public function testValidation1()
    {
        $data = [
            'name' => '12345',
            'password' => 'pass'
        ];

        $validator = new Validator();
        $validator->setData($data);

        $validator->validateLength('name', 1, 9, 'The Length of input name is between 1 and 9');
        $validator->validateNull('password', 'password is required');
        $errors = $validator->getErrors();
        $this->assertTrue(empty($errors));
    }

    public function testValidation2()
    {
        $data = [
            'name' => '1234567890',
            'password' => ''
        ];

        $validator = new Validator();
        $validator->setData($data);

        $validator->validateLength('name', 1, 9, 'The Length of input name is between 1 and 9');
        $validator->validateNull('password', 'password is required');
        $errors = $validator->getErrors();
        $this->assertTrue(isset($errors['name']));
        $this->assertTrue(isset($errors['password']));
    }
}
