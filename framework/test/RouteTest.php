<?php


use PHPUnit\Framework\TestCase;

use Minph\Utility\Pool;
use Minph\Exception\FileNotFoundException;


class RouteTest extends TestCase
{
    public function setup()
    {
    }

    public function testRoute()
    {
        $uri = '/';
        $route = Pool::get('route');
        try {
            $res = $route->run($uri);
            $this->assertEquals($res, 'index');
        } catch (FileNotFoundException $e) {
            $ret = $route->run('/404');
            $this->assertEquals($ret, 'error404');
        }

        $uri = '/404';
        try {
            $res = $route->run($uri);
            $this->assertEquals($res, 'error404');
        } catch (FileNotFoundException $e) {
            $res = $route->run('/404');
            $this->assertEquals($res, 'error404');
        }
        $uri = '/04';
        try {
            $res = $route->run($uri);

            // not reached.
            $this->assertTrue(false);
        } catch (FileNotFoundException $e) {
            $res = $route->run('/404');
            $this->assertEquals($res, 'error404');
        }
    }
}
