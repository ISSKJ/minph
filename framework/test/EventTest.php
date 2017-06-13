<?php

use PHPUnit\Framework\TestCase;
use Minph\Event\Event;


class EventTest extends TestCase
{
    public function setup()
    {
    }

    public function testLoadEvent()
    {
        $tag = ["tag_no"=>"123"];
        $ret = Event::fire('SampleEvent', $tag);
        $this->assertEquals($ret, $tag);
    }
}
