<?php

use PHPUnit\Framework\TestCase;
use Minph\Crypto\EncoderAES256;


class InputTest extends TestCase
{
    public function setup()
    {
    }

    public function testInput()
    {
        $key = getenv('AES256_CBC_KEY');
        $encoder = new EncoderAES256($key);

        $message = "Hello, world.";

        $enc = $encoder->encrypt($message);
        $dec = $encoder->decrypt($enc);

        $this->assertEquals($message, $dec);
    }

}
