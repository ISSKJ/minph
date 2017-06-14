<?php


use PHPUnit\Framework\TestCase;

use Minph\Http\Route;
use Minph\Exception\FileNotFoundException;


class RouteTest extends TestCase
{
    public function setup()
    {
    }

    public function testRoute()
    {
        $uri = '/';
        try {
            $res = Route::run($uri);
            $this->assertEquals($res, 'index');
        } catch (FileNotFoundException $e) {
            $ret = Route::run('/404');
            $this->assertEquals($ret, 'error404');
        }

        $uri = '/404';
        try {
            $res = Route::run($uri);
            $this->assertEquals($res, 'error404');
        } catch (FileNotFoundException $e) {
            $res = Route::run('/404');
            $this->assertEquals($res, 'error404');
        }
        $uri = '/04';
        try {
            $res = Route::run($uri);

            // not reached.
            $this->assertTrue(false);
        } catch (FileNotFoundException $e) {
            $res = Route::run('/404');
            $this->assertEquals($res, 'error404');
        }
    }
}
