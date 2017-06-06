<?php

require_once __DIR__ .'/BaseRepository.php';

use Minph\Repository\DBUtil;
use Minph\Repository\Pool;
use Minph\Utility\Pagination;


class HotelRepository extends BaseRepository
{
    public function createHotel(array $input)
    {
        return $this->create('hotels', $input);
    }

    public function getPagingHotels($page = 1, $fields = '*', $pageMax = 10)
    {
        if (DBUtil::validInput($fields, '.,*')) {
            $db = Pool::get('default');
            $offset = $pageMax * ($page - 1);
            $hotels = $db->query("SELECT $fields FROM hotels LIMIT $pageMax OFFSET $offset");
            $total = $db->queryOne("SELECT count(id) FROM hotels LIMIT 1");

            $pagination = new Pagination($page, $total['count'], $pageMax);
            return ['hotels' => $hotels, 'page' => $pagination->build()];
        }
        return null;
    }

    public function getAll($fields = '*', $orderClause = '', $limitClause = '')
    {
        if (DBUtil::validInput($fields, '.,*')) {
            $db = Pool::get('default');
            return $db->query("SELECT $fields FROM hotels $orderClause $limitClause");
        }
        return null;
    }

    public function deleteByID($id)
    {
        return $this->delete('hotels', 'id', $id);
    }

    public function findByID($id, $fields = '*')
    {
        if (DBUtil::validInput($fields, '.,*')) {
            $db = Pool::get('default');
            return $db->queryOne("SELECT $fields FROM hotels WHERE id = :id", ['id' => $id]);
        }
        return null;
    }
}

