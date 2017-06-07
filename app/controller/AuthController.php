<?php

use Minph\App;
use Minph\Crypt\EncoderAES256;
use Minph\Utility\Pool;


class AuthController
{
    public function register()
    {
        switch (Pool::get('header')->getMethod()) {
        case 'GET':
            $this->getRegister();
            break;
        case 'POST':
            $this->postRegister();
            break;
        default:
            break;
        };
    }

    private function getRegister()
    {
        $model = [
            'locale' => $this->getLocale()
        ];
        Pool::get('view')->view('auth/register.tpl', $model);
    }

    private function postRegister()
    {
        $userService = App::make('service', 'UserService');

        $in = Pool::get('input');
        $params['name'] = $in->get('inputFirstName') .' ' . $in->get('inputLastName');
        $params['email'] = $in->get('inputEmail');
        $params['password'] = $in->get('encodedPassword');
        try {
            $user = $userService->save($params);
            $this->userAuth($user);
        } catch (UserAuthException $e) {
            $error['error'] = $e->getMessage();
            $model = [
                'locale' => $this->getLocale(),
                'data' => $in->getAll(),
                'error' => $error
            ];
            Pool::get('view')->view('auth/register.tpl', $model);
        }
    }

    private function userAuth($user)
    {
        $session = Pool::get('session');
        if ($user) {
            $session->set('id', $user['id']);
        } else {
            $session->destroy();
        }
        Pool::get('route')->redirect('/');
    }

    public function confirmRegister()
    {
        $in = Pool::get('input');
        $data = $in->getAll();

        $validator = App::make('validation', 'MyValidator');

        $error = $validator->validate($data, [
            'inputFirstName' => 'validateLength(3,PHP_INT_MAX)|First name should be more than 3 characters',
            'inputLastName' => 'validateLength(3,PHP_INT_MAX)|Last name should be more than 3 characters',
            'inputEmail' => 'validateEmail()|Email address is invalid',
            'inputPassword' => 'validateNull()|password is required',
            'inputConfirmPassword' => 'validateNull()|confirm password is required',
        ]);

        if ($in->get('inputPassword') !== $in->get('inputConfirmPassword')) {
            $error['inputConfirmPassword'] = 'Password is different.';
        }
        if ($error) {
            $model = [
                'locale' => $this->getLocale(),
                'data' => $in->getAll(),
                'error' => $error
            ];
            Pool::get('view')->view('auth/register.tpl', $model);
            return;
        }

        $password = $in->get('inputPassword');

        $in->remove('inputPassword');
        $in->remove('inputConfirmPassword');

        $encoder = new EncoderAES256(App::env('AES256_CBC_KEY'));
        $enc = $encoder->encrypt($password);

        $in->put('encodedPassword', $enc);

        $model = [
            'locale' => $this->getLocale(),
            'data' => $in->getAll()
        ];

        Pool::get('view')->view('auth/confirm_register.tpl', $model);
    }


    public function login()
    {
        switch (Pool::get('header')->getMethod()) {
        case 'GET':
            $this->getLogin();
            break;
        case 'POST':
            $this->postLogin();
            break;
        default:
            break;
        };
    }

    private function getLogin()
    {
        Pool::get('view')->view('auth/login.tpl');
    }

    private function postLogin()
    {
        $in = Pool::get('input');
        $data = $in->getAll();

        $validator = App::make('validation', 'MyValidator');

        $error = $validator->validate($data, [
            'inputEmail' => 'validateEmail()|Email address is invalid',
            'inputPassword' => 'validateNull()|password is required',
            'inputConfirmPassword' => 'validateNull()|confirm password is required',
        ]);

        $in->remove('inputPassword');

        if ($error) {
            $model = [
                'data' => $in->getAll(),
                'error' => $error
            ];
            Pool::get('view')->view('auth/login.tpl', $model);
            return;
        }

        $userService = App::make('service', 'UserService');
        try {
            $user = $userService->login($data['inputEmail'], $data['inputPassword']);
            $this->userAuth($user);

        } catch (UserNotFoundException $e) {
            Pool::get('route')->redirect('/register');
        } catch (UserAuthException $e) {
            $error = ['inputPassword' => $e->getMessage()];
            $model = [
                'data' => $in->getAll(),
                'error' => $error
            ];
            Pool::get('view')->view('auth/login.tpl', $model);
        }
    }

    private function getLocale()
    {
        $locale = Pool::get('locale');
        if (!$locale->hasMap()) {
            $locale->loadMap('register.php');
        }
        return [
            'firstName' => $locale->gettext('firstName'),
            'lastName' => $locale->gettext('lastName'),
            'email' => $locale->gettext('email'),
            'password' => $locale->gettext('password'),
            'confirmPassword' => $locale->gettext('confirmPassword'),
            'signup' => $locale->gettext('signup')
        ];
    }
}
