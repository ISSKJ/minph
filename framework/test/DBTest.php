<?php

use PHPUnit\Framework\TestCase;
use Minph\Utility\Pool;
use Minph\App;
use Minph\Repository\DB;
use Minph\Repository\DBUtil;
use Minph\Crypto\EncoderAES256;


class DBTest extends TestCase
{

    public function setup()
    {
        if (!Pool::exists('db')) {
            $db = new DB(
                App::env('DATABASE_DSN'),
                App::env('DATABASE_USERNAME'),
                App::env('DATABASE_PASSWORD')
            );
            Pool::set('db', $db);
        }
        if (!Pool::exists('encoder')) {
            $encoder = new EncoderAES256(App::env('AES_CBC_256'));
            Pool::set('encoder', $encoder);
        }
    }

    public function testDB()
    {

        $db = Pool::get('db');
        $encoder = Pool::get('encoder');

        $name = 'Test name';
        $email = 'test@example.com';
        $password = 'Test password';

        $inputs = [
            'name' => $name,
            'email' => $email,
            'password' => $encoder->encrypt($password)
        ];
        $ret = $db->insert('users', $inputs);
        $this->assertEquals($ret, 1);

        $ret = $db->queryOne('SELECT * FROM users ORDER BY id DESC LIMIT 1');
        $this->assertEquals($ret['name'], $name);
        $this->assertEquals($ret['email'], $email);
        $this->assertEquals($encoder->decrypt($ret['password']), $password);
        $id = $ret['id'];


        $ret = $db->delete('users', 'id', $id);
        $this->assertEquals($ret, 1);

        $ret = $db->queryOne('SELECT * FROM users WHERE id = :id', ['id' => $id]);
        $this->assertEmpty($ret);

    }
}

