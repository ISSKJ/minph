<?php


require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../framework/vendor/autoload.php';

use Minph\App;

App::init(__DIR__);
//App::setTemplate(App::make('view', 'TemplateSmarty'));
App::run();
