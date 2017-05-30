<?php

use Minph\App;

class UserService
{
    private $repository;

    public function __construct()
    {
        $this->repository = App::make('repository', 'UserRepository');
    }

    public function getUser($id)
    {
    }
}
