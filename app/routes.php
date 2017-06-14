<?php

return [
    '/' => 'TopController@index',
    '/login' => 'LoginController@login',
    '/logout' => 'LoginController@logout',
    '/user' => 'AuthController@user',
    '/403' => 'ErrorController@error403',
    '/404' => 'ErrorController@error404'
];

