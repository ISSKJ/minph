<?php

use PHPUnit\Framework\TestCase;

use Minph\App;
use Minph\Crypto\EncoderAES256;
use Minph\Exception\AuthException;

class AuthServiceTest extends TestCase
{
    private $name;
    private $email;
    private $password;

    public function setup()
    {
        $repo = App::make('repository', 'UserRepository');
        $encoder = new EncoderAES256(App::env('AES256_CBC_KEY'));

        $this->name = 'Sample user';
        $this->email = 'test@example.com';
        $this->password = 'test123#';
        $encPassword = $encoder->encrypt($this->password);
        $input = [
            'name'      => $this->name,
            'email'     => $this->email,
            'password'  => $encPassword
        ];
        $repo->createUser($input);
    }

    public function tearDown()
    {
        $repo = App::make('repository', 'UserRepository');
        $repo->deleteUserByEmail($this->email);
    }

    public function testLogin()
    {
        $service = App::make('service', 'AuthService');

        $user = $service->login($this->email, $this->password);

        $this->assertNotNull($user);
        $this->assertEquals($user['name'], $this->name);
        $this->assertEquals($user['email'], $this->email);
    }

    public function testLoginFailed()
    {
        $service = App::make('service', 'AuthService');

        $email = null;
        $password = $this->password;
        try {
            $user = $service->login($email, $password);
        } catch (AuthException $e) {
            $this->assertNotNull($e);
        }

        $email = $this->email;
        $password = '';
        try {
            $user = $service->login($email, $password);
        } catch (AuthException $e) {
            $this->assertNotNull($e);
        }
    }
}
