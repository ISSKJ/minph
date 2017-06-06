<?php

use Minph\App;
use Minph\Http\Route;
use Minph\Http\Session;
use Minph\Repository\DB;
use Minph\View\View;

class TopController
{
    public function index()
    {
        if (!Session::has('id')) {
            Route::redirect('/login');
        }

        $id = Session::get('id');

        $userService = App::make('service', 'UserService');
        $user = $userService->getUser($id);

        $model = [
            'user' => $user
        ];
        View::view('top.tpl', $model);
    }
}
