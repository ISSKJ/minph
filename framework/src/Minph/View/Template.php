<?php

namespace Minph\View;

interface Template
{
    public function view($file, $model = null);
}
