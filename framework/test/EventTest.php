<?php

require_once __DIR__ . '/bootForTest.php';

use PHPUnit\Framework\TestCase;
use Minph\Event\Event;


class DBTest extends TestCase
{
    public function setup()
    {
    }

    public function testLoadEvent()
    {
        $tag = ["tag_no"=>"123"];
        Event::fire('SampleEvent', $tag);
        $this->assertTrue(true);
    }
}
