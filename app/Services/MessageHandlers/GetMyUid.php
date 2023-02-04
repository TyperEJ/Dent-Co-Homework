<?php

namespace App\Services\MessageHandlers;

use Closure;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class GetMyUid implements MessageEventHandler
{
    public function handle(MessageEvent $message, Closure $next)
    {
        if (
            $message instanceof TextMessage &&
            $message->getText() === 'UID'
        ) {
            return new TextMessageBuilder($message->getUserId());
        }

        return $next($message);
    }
}
