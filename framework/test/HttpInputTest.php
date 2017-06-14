<?php

define('USERNAME', 'Test user');
define('PAGE', 1);
define('PASSWORD', 'Test password');

use PHPUnit\Framework\TestCase;
use Minph\Http\Input;
use Minph\Utility\Pool;


class HttpInputTest extends TestCase
{
    public function setup()
    {
    }

    public function testInput()
    {
        $data = Input::get();
        $this->assertEquals($data['username'], USERNAME);
        $this->assertEquals($data['page'], PAGE);
        $this->assertEquals($data['password'], PASSWORD);
    }

}
