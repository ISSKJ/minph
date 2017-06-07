<?php

use Minph\Repository\Pool;

class ErrorController
{
    public function error404()
    {
        Pool::get('view')->view('404.tpl');
    }
    public function error500()
    {
        Pool::get('view')->view('500.tpl');
    }
}
