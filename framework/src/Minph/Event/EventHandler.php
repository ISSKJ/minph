<?php

namespace Minph\Event;

/**
 * @interface Minph\Event\EventHandler
 *
 * Event class should implements this interface.
 */
interface EventHandler
{
    /**
     * @method handle
     * @param `$tag` optional argument
     *
     * If an event is fired, this method would be called.
     */
    public function handle($tag);
}
