<?php

require_once __DIR__ .'/BaseRepository.php';

use Minph\Utility\Pool;
use Minph\Repository\DB;
use Minph\Repository\DBUtil;
use Minph\App;

class UserRepository extends BaseRepository
{

    public function findByEmail($email, $fields = '*')
    {
        $db = Pool::get('default');
        if (DBUtil::validInput($fields, ',*')) {
            return $db->queryOne("SELECT $fields FROM users WHERE email = :email", ['email' => $email]);
        } else {
            return null;
        }
    }

    public function createUser($input)
    {
        return parent::create('users', $input);
    }

    public function deleteUser($id)
    {
        return parent::delete('users', 'id', $id);
    }

    public function deleteUserByEmail($email)
    {
        return parent::delete('users', 'email', $email);
    }
}
