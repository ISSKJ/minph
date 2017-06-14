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
            $this->postLogin($request['input']);
        } else {
            $this->getLogin($request['input']);
        }
    }

    public function logout($request, $tag)
    {
        $user = Session::get('user');
        $username = '';
        if ($user) {
            $username = $user['name'];
        }
        $model = [
            'username' => $username
        ];
        Session::destroy();
        View::view('user/logout.tpl', $model);
    }

    private function postLogin($data)
    {
        $errors = $this->validation($data);
        if (!empty($errors)) {
            $this->getLogin($data, $errors);
            return;
        }

        $userService = App::make('service', 'AuthService');
        try {
            $user = $userService->login($data['email'], $data['password']);

            Session::set('user', $user);
            Route::redirect('/user');

        } catch (AuthException $e) {
            $errors = ['auth' => $this->locale->gettext('error.authentication')];
            $this->getLogin($data, $errors);
        }
    }

    private function getLogin($data, array $errors = [])
    {
        $model = [
            'data' => $data,
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
