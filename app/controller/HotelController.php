<?php

use Minph\App;
use Minph\Utility\Number;
use Minph\Utility\Pool;

class HotelController
{
    public function getHotels()
    {
        $session = Pool::get('session');
        if (!$session->has('id')) {
            Pool::get('route')->redirect('/login');
        }

        $hotelService = App::make('service', 'HotelService');
        $page = Number::toInt(Pool::get('input')->get('page'), 1);
        $model = $hotelService->getHotels($page);

        Pool::get('view')->view('hotel/hotel_list.tpl', $model);
    }
}
