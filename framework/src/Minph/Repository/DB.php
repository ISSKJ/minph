<?php

namespace Minph\Repository;

use PDO;

class DB
{
    private $db;

    public function __construct(string $dsn = null, string $username = null, string $password = null)
    {
        if ($dsn && $username && $password) {
            $this->db = new PDO(
                $dsn,
                $username,
                $password);
        } else {
            $this->db = new PDO(
                getenv('DATABASE_DSN'),
                getenv('DATABASE_USERNAME'),
                getenv('DATABASE_PASSWORD'));
        }
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

    public function transaction(string $sql, array $params = null)
    {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare($sql);
            if ($params) {
                foreach ($params as $key => $val) {
                    $stmt->bindValue($key, $val);
                }
            }
            $stmt->execute();
            $this->db->commit();

        } catch (PDOException $e) {
            $this->db->rollback();
            throw $e;
        }
        return $stmt->rowCount();
    }

    public function insert(string $table, array $input)
    {
        $columns = [];
        $bindColumns = [];
        foreach ($input as $key => $value) {
            $columns[] = $key;
            $bindColumns[] = ":$key";
        }
        return $this->transaction(
            'INSERT INTO ' .$table .' (' .implode(',', $columns) .') VALUES (' .implode(',', $bindColumns) .')', $input);
    }

    public function delete(string $table, string $idColumn, int $id)
    {
        return $this->transaction(
            "DELETE FROM $table WHERE $idColumn = :$idColumn", [$idColumn => $id]);
    }
}

