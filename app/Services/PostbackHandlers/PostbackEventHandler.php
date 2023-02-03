<?php

namespace App\Services\PostbackHandlers;

use Closure;
use LINE\LINEBot\Event\PostbackEvent;

interface PostbackEventHandler
{
    public function handle(PostbackEvent $message, Closure $next);
}
