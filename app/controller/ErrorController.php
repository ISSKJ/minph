<?php

use Minph\View\View;
use Minph\Event\Event;
use Minph\App;
use Minph\Repository\DB;

class ErrorController
{
    public function error404()
    {
        View::view('404.tpl');
    }
    public function error500()
    {
        View::view('500.tpl');
    }
}
