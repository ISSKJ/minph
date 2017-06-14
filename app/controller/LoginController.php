<?php

use Minph\App;
use Minph\Http\Session;
use Minph\Http\Route;
use Minph\View\View;
use Minph\Localization\Locale;
use Minph\Exception\AuthException;


class LoginController
{
    private $locale;

    public function __construct()
    {
        $this->locale = Locale::loadMap('login.php');
    }

    public function login($request, $tag)
    {
        if ($request['method'] === 'POST') {
            $this->postLogin($request);
        } else {
            $this->getLogin($request);
        }
    }

    public function logout($request, $tag)
    {
        $user = Session::get('user');
        Session::destroy();
        View::view('user/logout.tpl', $user);
    }

    private function postLogin($request)
    {
        $data = $request['input'];
        $errors = $this->validation($data);
        if (!empty($errors)) {
            $this->getLogin($request, $errors);
            return;
        }

        $userService = App::make('service', 'AuthService');
        try {
            $user = $userService->login($data['email'], $data['password']);

            Session::set('user', $user);
            Route::redirect('/user');

        } catch (AuthException $e) {
            $errors = ['auth' => $this->locale->gettext('error.authentication')];
            $this->getLogin($request, $errors);
        }
    }

    private function getLogin($request, array $errors = [])
    {
        $model = [
            'data' => $request['input'],
            'errors' => $errors
        ];
        View::view('user/login.tpl', $model);
    }

    private function validation($data)
    {
        $validator = App::make('validator', 'MyValidator');
        $validator->setData($data);
        $validator->validateEmail('email', $this->locale->gettext('validate.email'));
        $validator->validatePassword('password', $this->locale->gettext('validate.password'));

        return $validator->getErrors();
    }
}
