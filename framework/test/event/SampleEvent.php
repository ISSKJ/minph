<?php

use Minph\Event\EventHandler;

class SampleEvent implements EventHandler
{
    public function handle($tag = null)
    {
        return $tag;
    }
}
