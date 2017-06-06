<?php

return [
    '/' => 'TopController@index',
    '/404' => 'ErrorController@error404',
    '/login' => 'AuthController@login',
    '/register' => 'AuthController@register',
    '/confirmRegister' => 'AuthController@confirmRegister',
    '/hotels' => 'HotelController@getHotels'
];

