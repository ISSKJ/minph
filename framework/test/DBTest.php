<?php

require_once __DIR__ . '/bootForTest.php';

use PHPUnit\Framework\TestCase;
use Minph\Repository\Pool;
use Minph\Repository\DB;
use Minph\Repository\DBUtil;


class DBTest extends TestCase
{
    public function setup()
    {
    }

    public function testDB()
    {
        if (!Pool::exists('db')) {
            $db = new DB();
            Pool::set('db', $db);
        }

        $db = Pool::get('db');

        $inputs = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'email' => 'Test Email',
            'password' => 'Test Password'
        ];
        $db->insert('users', $inputs);
        $ret = $db->queryOne('SELECT * FROM users ORDER BY id DESC LIMIT 1');
        $this->assertTrue($ret['password'] === 'Test Password');

        $testData = $db->query('SELECT id FROM users WHERE name = \'Test Name\'');
        foreach ($testData as $row) {
            $db->delete('users', 'id', intval($row['id']));
        }
        $testData = $db->query('SELECT id FROM users WHERE name = \'Test Name\'');
        $this->assertTrue(count($testData) === 0);
    }
}


