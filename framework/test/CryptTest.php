<?php

require_once __DIR__ . '/bootForTest.php';

use PHPUnit\Framework\TestCase;
use Minph\Crypt\Encoder;


class InputTest extends TestCase
{
    public function setup()
    {
    }

    public function testInput()
    {
        $key = getenv('AES256_KEY');
        $encoder = new Encoder($key);

        $message = "Hello world";
        var_dump("orig:".$message);

        $enc = $encoder->encryptAES256($message);
        var_dump("enc:".$enc);

        $dec = $encoder->decryptAES256($enc);
        var_dump("dec:".$dec);

        $this->assertEquals($message, $dec);
    }

}
