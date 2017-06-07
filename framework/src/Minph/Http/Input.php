<?php

namespace Minph\Http;

use Minph\Exception\InputException;


/**
 * @class Minph\Http\Input
 *
 * It contains $_GET, $_POST, raw(php://input) values.
 */
class Input
{
    private $data = [];

    /**
     * @method construct
     */
    public function __construct()
    {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $this->data[$key] = $value;
            }
        }
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $this->data[$key] = $value;
            }
        }
        if (isset($_SERVER['CONTENT_TYPE'])) {
            $this->data['raw'] = file_get_contents('php://input');
        }
    }

    /**
     * @method remove
     * @param string `$key`
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }

    /**
     * @method put
     * @param string `$key`
     * @param `$value`
     */
    public function put($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @method get
     * @param string `$key`
     * @param boolean `$required`
     * @throws `Minph\Exception\InputException` If `$required` is true and a value doesn't exist, it occurs.
     * @return input value
     */
    public function get($key, $required = false)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else if ($required) {
            throw new InputException('key "' . $key . '" is required');
        } else {
            return null;
        }
    }

    /**
     * @method getAll
     * @return array all the values
     */
    public function getAll()
    {
        return $this->data;
    }
}
