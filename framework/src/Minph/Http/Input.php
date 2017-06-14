<?php

namespace Minph\Http;

use Minph\Exception\InputException;


/**
 * @class Minph\Http\Input
 *
 * User input utility class.
 */
class Input
{

    /**
     * @method (static) get
     * @return array user input data
     */
    public static function get()
    {
        $data = [];
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $data[$key] = $value;
            }
        }
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }
        }
        if (isset($_SERVER['CONTENT_TYPE'])) {
            $data['raw'] = file_get_contents('php://input');
        }
        return $data;
    }

}
