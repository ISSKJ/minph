<?php

require_once __DIR__ .'/../framework/vendor/autoload.php';
require_once __DIR__ .'/../vendor/autoload.php';

use Minph\App;
use Minph\Http\Route;
use Minph\Exception\FileNotFoundException;
use Minph\Exception\AuthException;


App::init(__DIR__);
App::setupDebugger();
App::setTemplate(App::make('template', 'TemplateSmarty'));

App::run(function($uri){
    $tag = null;
    try {
        $status = Route::run($uri);
    } catch (FileNotFoundException $e) {
        $status = 404;
        $tag = $e;
    } catch (AuthException $e) {
        $status = 403;
        $tag = $e;
    }

    switch ($status) {
    case 404:
        Route::run('/404', $tag);
        break;
    case 403:
        Route::run('/403', $tag);
        break;
    default:
        break;
    }
});
