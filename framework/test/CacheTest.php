<?php

require_once __DIR__ . '/bootForTest.php';

use PHPUnit\Framework\TestCase;
use Minph\Repository\Pool;


class CacheTest extends TestCase
{
    public function setup()
    {
    }

    public function testMemcached()
    {
        if (!Pool::exists('memcached')) {
            $obj = new Memcached;
            $obj->addServer(
                getenv('MEMCACHED_HOST'),
                getenv('MEMCACHED_PORT'),
                getenv('MEMCACHED_WEIGHT'));

            Pool::set('memcached', $obj);
            $obj->set('foo', 'hello foo');
        }

        $cache = Pool::get('memcached');
        $foo = $cache->get('foo');
        $this->assertNotNull($foo);
        $cache = Pool::get('memcached');
        $foo = $cache->get('cache_not_exists');
        $this->assertFalse($foo);
    }

    public function testRedis()
    {
        if (!Pool::exists('redis')) {
            $obj = new Redis;
            $obj->connect(
                getenv('REDIS_HOST'),
                getenv('REDIS_PORT'));
            Pool::set('redis', $obj);
            $obj->set('bar', 'hello bar');
        }

        $cache = Pool::get('redis');
        $bar = $cache->get('bar');
        $this->assertNotNull($bar);
        $bar = $cache->get('cache_not_exists');
        $this->assertFalse($bar);
    }

    public function testCacheSingleton()
    {
        $cache = Pool::get('redis');
        $bar = $cache->get('bar');
        $this->assertNotNull($bar);
        $bar = $cache->get('cache_not_exists');
        $this->assertFalse($bar);

        $cache = Pool::get('memcached');
        $foo = $cache->get('foo');
        $this->assertNotNull($foo);
        $cache = Pool::get('memcached');
        $foo = $cache->get('cache_not_exists');
        $this->assertFalse($foo);
    }
}


