<?php

namespace App\Events;

use LINE\LINEBot\Event\MessageEvent as LineMessageEvent;

class MessageEvent extends LineEvent
{
    private LineMessageEvent $lineMessageEvent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LineMessageEvent $lineMessageEvent)
    {
        $this->lineMessageEvent = $lineMessageEvent;
    }

    public function getReplyToken(): string
    {
        return $this->lineMessageEvent->getReplyToken();
    }

    public function getMessage(): LineMessageEvent
    {
        return $this->lineMessageEvent;
    }
}
