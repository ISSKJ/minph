<?php

use Minph\View\View;


class TopController
{
    public function index($request, $tag)
    {
        View::view('top.tpl');
    }
}
