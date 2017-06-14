<?php

use Minph\App;
use Minph\Exception\AuthException;
use Minph\Crypto\EncoderAES256;

class AuthService
{
    private $repo;

    private $encoder;

    public function __construct()
    {
        $this->repo = App::make('repository', 'UserRepository');
        $this->encoder = new EncoderAES256(App::env('AES256_CBC_KEY'));
    }

    public function login($email, $password)
    {
        $user = $this->repo->findByEmail($email, 'id, name, email, password');
        if (!$user) {
            throw new AuthException('user not found');
        }

        $decPassword = $this->encoder->decrypt($user['password']);
        if ($password !== $decPassword) {
            throw new AuthException('password not matched');
        }
        unset($user['password']);
        return $user;
    }
}
