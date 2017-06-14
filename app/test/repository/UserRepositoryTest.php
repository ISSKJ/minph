<?php

use PHPUnit\Framework\TestCase;

use Minph\App;
use Minph\Crypto\EncoderAES256;

class UserRepositoryTest extends TestCase
{
    public function setup()
    {
    }

    public function testCRUD()
    {
        $repo = App::make('repository', 'UserRepository');
        $encoder = new EncoderAES256(App::env('AES256_CBC_KEY'));

        $email = 'test@example.com';
        $password = 'test123#';
        $encPassword = $encoder->encrypt($password);
        $input = [
            'name' => 'Sample user',
            'email' => $email,
            'password' => $encPassword
        ];
        $ret = $repo->createUser($input);
        $this->assertEquals($ret, 1);

        $user = $repo->findByEmail($email);
        $this->assertNotNull($user);

        $ret = $repo->deleteUserByEmail($email);
        $this->assertTrue($ret >= 1);
    }

}
