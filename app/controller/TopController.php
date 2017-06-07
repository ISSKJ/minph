<?php

use Minph\App;
use \Minph\Utility\Pool;


class TopController
{
    public function index()
    {
        $session = Pool::get('session');
        if (!$session->has('id')) {
            Pool::get('route')->redirect('/login');
        }

        $id = $session->get('id');

        $userService = App::make('service', 'UserService');
        $user = $userService->getUser($id);

        $locale = Pool::get('locale');
        if (!$locale->hasMap()) {
            $locale->loadMap('register.php');
        }
        $model = [
            'user' => $user,
            'hello' => Pool::get('locale')->gettext('hello')
        ];
        Pool::get('view')->view('top.tpl', $model);
    }
}
