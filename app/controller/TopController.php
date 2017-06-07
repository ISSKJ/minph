<?php

use Minph\Utility\Pool;


class TopController
{
    public function index()
    {
        $model = [
            'framework' => 'Minph framework'
        ];
        Pool::get('view')->view('top.tpl', $model);
    }
}
