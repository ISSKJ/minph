<?php

require_once __DIR__ .'/BaseRepository.php';

use Minph\Repository\DBUtil;
use Minph\Repository\Pool;


class UserRepository extends BaseRepository
{
    public function createUser(array $input)
    {
        return $this->create('users', $input);
    }

    public function getAll($fields = '*', $orderClause = '', $limitClause = '')
    {
        if (DBUtil::validInput($fields, '.,*')) {
            $db = Pool::get('default');
            return $db->query("SELECT $fields FROM users $orderClause $limitClause");
        }
        return null;
    }

    public function deleteUserByID($id)
    {
        return $this->delete('users', 'id', $id);
    }

    public function findUserByID($id, $fields = '*')
    {
        if (DBUtil::validInput($fields, '.,*')) {
            $db = Pool::get('default');
            return $db->queryOne("SELECT $fields FROM users WHERE id = :id", ['id' => $id]);
        }
        return null;
    }
}

