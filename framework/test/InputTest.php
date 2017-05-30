<?php

require_once __DIR__ . '/bootForTest.php';

use PHPUnit\Framework\TestCase;
use Minph\Http\Input;


class InputTest extends TestCase
{
    public function setup()
    {
        $_GET['username'] = 'Test User';
        $_GET['page'] = 1;
        $_POST['password'] = 'Test pass';
        Input::init();
    }

    public function testInput()
    {
        $username = Input::get('username');
        $this->assertEquals($username, 'Test User');
        $password = Input::get('password');
        $this->assertEquals($password, 'Test pass');
    }

}
