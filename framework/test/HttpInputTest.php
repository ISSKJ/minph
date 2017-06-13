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
        $in = Pool::get('input');
        $this->assertEquals($in->get('username'), USERNAME);
        $this->assertEquals($in->get('page'), PAGE);
        $this->assertEquals($in->get('password'), PASSWORD);
    }

}
