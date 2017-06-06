<?php

require_once __DIR__ .'/../exception/UserNotFoundException.php';
require_once __DIR__ .'/../exception/UserAuthException.php';

use Minph\App;
use Minph\Crypt\Encoder;
use Tracy\Debugger;

class UserService
{
    private $repository;

    public function __construct()
    {
        $this->repository = App::make('repository', 'UserRepository');
    }

    public function getUser($id)
    {
        $user = $this->repository->findByID($id);
        unset($user['password']);
        return $user;
    }
    public function login($email, $password)
    {
        $user = $this->repository->findByEmail($email);
        if (!$user) {
            throw new UserNotFoundException('user not found.');
        }
        $encoder = new Encoder(getenv('AES256_CBC_KEY'));
        try {
            $pass = $encoder->decryptAES256($user['password']);
        } catch (Exception $e) {
            throw new UserAuthException($e);//'password is different');
        }
        if ($pass !== $password) {
            throw new UserAuthException('password is different');
        }
        return $user;
    }

    public function save($params)
    {
        $user = $this->repository->findByEmail($params['email'], 'id');
        if ($user) {
            throw new UserAuthException('User "' .$params['email'] .'" is already registered.');
        }

        try {
            $affected = $this->repository->createUser($params);
            if ($affected == 1) {
                return $this->repository->findByEmail($params['email']);
            }

        } catch (Exception $e) {
            Debugger::log($e);
            throw new UserAuthException('Unexpected error occurs. Please contact with an server administrator.');
        }
        return null;
    }
}
