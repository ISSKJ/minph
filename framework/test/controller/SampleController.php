<?php

use Minph\Http\Input;

class SampleController
{
    public function index()
    {
        return "index";
    }
    public function error404()
    {
        return "error404";
    }
    public function get()
    {
        return Input::getAll();
        return "index";
    }
}
