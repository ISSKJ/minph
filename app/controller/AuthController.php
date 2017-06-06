<?php

use Tracy\Debugger;
use Minph\App;
use Minph\Crypt\Validator;
use Minph\Crypt\Encoder;
use Minph\Http\Header;
use Minph\Http\Session;
use Minph\Http\Input;
use Minph\Http\Route;
use Minph\View\View;


class AuthController
{
    public function register()
    {
        switch (Header::getMethod()) {
        case 'GET':
            $this->getRegister();
            break;
        case 'POST':
            $this->postRegister();
        default:
            break;
        };
    }

    private function getRegister()
    {
        View::view('auth/register.tpl');
    }

    private function postRegister()
    {
        $userService = App::make('service', 'UserService');

        $params['name'] = Input::get('inputFirstName') . Input::get('inputLastName');
        $params['email'] = Input::get('inputEmail');
        $params['password'] = Input::get('encodedPassword');
        try {
            $user = $userService->save($params);
            $this->userAuth($user);
        } catch (UserAuthException $e) {
            $error['error'] = $e->getMessage();
            $model = [
                'data' => Input::getAll(),
                'error' => $error
            ];
            View::view('auth/register.tpl', $model);
        }
    }

    private function userAuth($user)
    {
        if ($user) {
            Session::set('id', $user['id']);
        } else {
            Session::destroy();
        }
        Route::redirect('/');
    }

    public function confirmRegister()
    {
        $data = Input::getAll();
        $error = [];

        $validator = App::make('validation', 'MyValidator');

        $error = $validator->validate($data, [
            'inputFirstName' => 'validateLength(3,PHP_INT_MAX)|First name should be more than 3 characters',
            'inputLastName' => 'validateLength(3,PHP_INT_MAX)|Last name should be more than 3 characters',
            'inputEmail' => 'validateEmail()|Email address is invalid',
            'inputPassword' => 'validateNull()|password is required',
            'inputConfirmPassword' => 'validateNull()|confirm password is required',
        ]);

        if (Input::get('inputPassword') !== Input::get('inputConfirmPassword')) {
            $error['inputConfirmPassword'] = 'Password is different.';
        }
        if ($error) {
            $model = [
                'data' => Input::getAll(),
                'error' => $error
            ];
            View::view('auth/register.tpl', $model);
            return;
        }

        $password = Input::get('inputPassword');

        Input::remove('inputPassword');
        Input::remove('inputConfirmPassword');

        $encoder = new Encoder(App::env('AES256_CBC_KEY'));
        $enc = $encoder->encryptAES256($password);

        Input::put('encodedPassword', $enc);

        $model = [ 'data' => Input::getAll() ];

        View::view('auth/confirm_register.tpl', $model);
    }


    public function login()
    {
        switch (Header::getMethod()) {
        case 'GET':
            $this->getLogin();
            break;
        case 'POST':
            $this->postLogin();
        default:
            break;
        };
    }

    private function getLogin()
    {
        View::view('auth/login.tpl');
    }

    private function postLogin()
    {
        $data = Input::getAll();

        $validator = App::make('validation', 'MyValidator');

        $error = $validator->validate($data, [
            'inputEmail' => 'validateEmail()|Email address is invalid',
            'inputPassword' => 'validateNull()|password is required',
            'inputConfirmPassword' => 'validateNull()|confirm password is required',
        ]);

        Input::remove('inputPassword');

        if ($error) {
            $model = [
                'data' => Input::getAll(),
                'error' => $error
            ];
            View::view('auth/login.tpl', $model);
            return;
        }

        $userService = App::make('service', 'UserService');
        try {
            $user = $userService->login($data['inputEmail'], $data['inputPassword']);
            $this->userAuth($user);

        } catch (UserNotFoundException $e) {
            Route::redirect('/register');
        } catch (UserAuthException $e) {
            $error = ['inputPassword' => $e->getMessage()];
            $model = [
                'data' => Input::getAll(),
                'error' => $error
            ];
            View::view('auth/login.tpl', $model);
        }
    }
}
