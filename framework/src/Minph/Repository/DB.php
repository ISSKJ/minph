<?php

namespace Minph\Repository;

use PDO;

class DB
{
    private $db;

    public function __construct(string $dsn = null, string $username = null, string $password = null)
    {
        $this->db = new PDO(
            $dsn,
            $username,
            $password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __destruct()
    {
        $this->db = null;
    }

    public function query(string $sql, array $params = null)
    {
        $stmt = $this->db->prepare($sql);
        if ($params) {
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
        }
        $res = null;
        if ($stmt->execute()) {
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $res;
    }

    public function queryOne(string $sql, array $params = null)
    {
        $stmt = $this->db->prepare($sql);
        if ($params) {
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
        }
        $res = null;
        if ($stmt->execute()) {
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $res;
    }

    public function execute(string $sql, array $params = null)
    {
        $stmt = $this->db->prepare($sql);
        if ($params) {
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
        }
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    public function commit()
    {
        return $this->db->commit();
    }
    public function rollback()
    {
        return $this->db->rollback();
    }

    public function insert(string $table, array $input)
    {
        $columns = [];
        $bindColumns = [];
        foreach ($input as $key => $value) {
            $columns[] = $key;
            $bindColumns[] = ":$key";
        }
        return $this->execute(
            'INSERT INTO ' .$table .' (' .implode(',', $columns) .') VALUES (' .implode(',', $bindColumns) .')', $input);
    }

    public function delete(string $table, string $idColumn, int $id)
    {
        return $this->execute(
            "DELETE FROM $table WHERE $idColumn = :$idColumn", [$idColumn => $id]);
    }
}

