<?php

namespace Minph\Repository;

use PDO;

/**
 * @class Minph\Repository\DB
 *
 */
class DB
{
    private $db;

    /**
     * @method construct
     * @param string `$dsn` database source name
     * @param string `$username`
     * @param string `$password`
     *
     * Instantiate PDO object.
     */
    public function __construct($dsn = null, $username = null, $password = null)
    {
        $this->db = new PDO(
            $dsn,
            $username,
            $password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @method destruct
     *
     * Release PDO object.
     */
    public function __destruct()
    {
        $this->db = null;
    }

    /**
     * @method query
     * @param string `$sql`
     * @param array `$params` (default = null)
     * @return array result rows or null
     *
     * For example,
     * ```
     * query('SELECT * FROM users WHERE name LIKE :name', [ ':name' => 'Test' ]);
     *
     * returns array(
     *     [0] => {result row 0},
     *     [1] => {result row 1},
     *     [2] => {result row 2},
     *     ...
     *  );
     *  ```
     */
    public function query($sql, array $params = null)
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
        if ($res === false) {
            return null;
        }
        return $res;
    }

    /**
     * @method queryOne
     * @param string `$sql`
     * @param array `$params` (default = null)
     * @return result row or null
     *
     * For example,
     * ```
     * queryOne('SELECT * FROM users WHERE id = :id', [ ':id' => 1 ]);
     *
     * returns {result row};
     * ```
     */
    public function queryOne($sql, array $params = null)
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
        if ($res === false) {
            return null;
        }
        return $res;
    }

    /**
     * @method execute
     * @param string `$sql`
     * @param array `$params` (default = null)
     * @return int the count of affected rows
     *
     * For example,
     * ```
     * execute('DELETE FROM users WHERE id = :id', [ ':id' => 1 ]);
     *
     * returns 1 (the count of affected rows);
     * ```
     */
    public function execute($sql, array $params = null)
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

    /**
     * @method beginTransaction
     */
    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    /**
     * @method commit
     */
    public function commit()
    {
        return $this->db->commit();
    }

    /**
     * @method rollback
     *
     * For example,
     *
     * ```
     * try {
     *     $db->beginTransactoin();
     *
     *     $db->execute('DELETE FROM ...');
     *     $db->execute('DELETE FROM ...');
     *     $db->execute('DELETE FROM ...');
     *     ..
     *     $db->commit();
     *
     * } catch (Exception $e) {
     *     $db->rollback();
     * }
     *
     * ```
     */
    public function rollback()
    {
        return $this->db->rollback();
    }

    /**
     * @method insert
     * @param string `$table`
     * @param array `$input`
     * @return int the count of affected rows
     *
     * For example,
     * ```
     * $params = [
     *     'name' => 'Test name',
     *     'email' => 'test@example.com',
     *     'address' => 'Sample street, Test wards, Tokyo, Japan',
     *     'age' => '32'
     * ];
     * $count = insert('users', $params);
     * ```
     */
    public function insert($table, array $input)
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

    /**
     * @method delete
     * @param string `$table`
     * @param string `$idColumn` id column name
     * @param `$id` id value
     * @return int the count of affected rows
     *
     * For example,
     * ```
     * $count = delete('users', 'id', 1);
     * ```
     */
    public function delete($table, $idColumn, $id)
    {
        return $this->execute(
            "DELETE FROM $table WHERE $idColumn = :$idColumn", [$idColumn => $id]);
    }
}

