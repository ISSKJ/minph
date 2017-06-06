<?php

use Minph\App;
use Minph\Utility\Number;
use Minph\Http\Route;
use Minph\Http\Input;
use Minph\Http\Session;
use Minph\Repository\DB;
use Minph\View\View;

class HotelController
{
    public function getHotels()
    {
        if (!Session::has('id')) {
            Route::redirect('/login');
        }

        $id = Session::get('id');

        $userService = App::make('service', 'UserService');
        $user = $userService->getUser($id);

        $hotelService = App::make('service', 'HotelService');
        $page = Number::toInt(Input::get('page'), 1);
        $model = $hotelService->getHotels($page);

        View::view('hotel/hotel_list.tpl', $model);
    }
}
