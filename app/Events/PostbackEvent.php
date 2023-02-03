<?php

namespace App\Events;

use LINE\LINEBot\Event\PostbackEvent as LinePostbackEvent;

class PostbackEvent extends LineEvent
{
    private LinePostbackEvent $linePostbackEvent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LinePostbackEvent $linePostbackEvent)
    {
        $this->linePostbackEvent = $linePostbackEvent;
    }

    public function getReplyToken(): string
    {
        return $this->linePostbackEvent->getReplyToken();
    }

    public function getPostback(): LinePostbackEvent
    {
        return $this->linePostbackEvent;
    }
}
