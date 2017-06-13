<?php

use PHPUnit\Framework\TestCase;
use Minph\Repository\DBUtil;


final class DBUtilTest extends TestCase
{
    public function setup()
    {
    }

    public function testValidInput()
    {
        $permission = ',*';

        $input = 'name, password';
        $ret = DBUtil::validInput($input, $permission);
        $this->assertTrue($ret);

        $input = '*';
        $ret = DBUtil::validInput($input, $permission);
        $this->assertTrue($ret);

        $input = ';where 1';
        $ret = DBUtil::validInput($input, $permission);
        $this->assertFalse($ret);
    }
}
