<?php

require_once __DIR__ .'/../../boot.php';

use PHPUnit\Framework\TestCase;
use Minph\App;


class HotelServiceTest extends TestCase
{
    public function setup()
    {
    }

    public function testGetPagingHotels()
    {
        $service = App::make('service', 'HotelService');
        $obj = $service->getHotels(1, 'id, name', '3');
        var_dump($obj);
        $obj = $service->getHotels(2, 'id, name', '3');
        var_dump($obj);
        $obj = $service->getHotels(3, 'id, name', '3');
        var_dump($obj);
    }
}

