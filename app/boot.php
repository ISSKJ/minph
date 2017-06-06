<?php

require_once __DIR__ .'/../framework/vendor/autoload.php';
require_once __DIR__ .'/../vendor/autoload.php';

use Minph\App;


App::init(__DIR__);
App::setupDebugger();
App::setTemplate(App::make('template', 'TemplateSmarty'));
App::run();
