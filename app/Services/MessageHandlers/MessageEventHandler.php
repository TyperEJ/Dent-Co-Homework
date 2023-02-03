<?php

namespace App\Services\MessageHandlers;

use Closure;
use LINE\LINEBot\Event\MessageEvent;

interface MessageEventHandler
{
    public function handle(MessageEvent $message, Closure $next);
}
