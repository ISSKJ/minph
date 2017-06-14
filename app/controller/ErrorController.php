<?php

use Minph\View\View;


class ErrorController
{

    public function error403($request, $tag)
    {
        $model = [
            'error' => $tag->getMessage()
        ];
        View::view('error/403.tpl', $model);
    }

    public function error404($request, $tag)
    {
        $model = [
            'error' => $tag->getMessage()
        ];
        View::view('error/404.tpl', $model);
    }

}
