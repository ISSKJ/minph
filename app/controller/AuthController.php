<?php

use Minph\Http\Session;
use Minph\View\View;
use Minph\Exception\AuthException;


class AuthController
{

    public function __construct()
    {
        if (!Session::has('user')) {
            throw new AuthException("authorization failed.");
        }
    }

    public function user($request, $tag)
    {
        $model = [
            'user' => Session::get('user')
        ];
        View::view('user/user.tpl', $model);
    }
}
