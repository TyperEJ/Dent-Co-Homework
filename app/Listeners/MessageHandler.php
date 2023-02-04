<?php

namespace App\Listeners;

use App\Events\MessageEvent;
use App\Exceptions\LineBotPushException;
use App\Services\LineBotService;
use App\Services\MessageHandlers\GetMyUid;
use App\Services\MessageHandlers\KeywordReplyFlexMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\MessageBuilder;

class MessageHandler
{
    private array $pipes = [
        KeywordReplyFlexMessage::class,
        GetMyUid::class,
    ];

    private LineBotService $lineBotService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LineBotService $lineBotService)
    {
        $this->lineBotService = $lineBotService;
    }

    /**
     * Handle the event.
     *
     * @param MessageEvent $event
     * @return void
     * @throws LineBotPushException
     */
    public function handle(MessageEvent $event): void
    {
        $message = app(Pipeline::class)
            ->send($event->getMessage())
            ->through($this->pipes)
            ->thenReturn();

        if ($message instanceof MessageBuilder) {
            $this->lineBotService->replyMessage($event->getReplyToken(), $message);
        }
    }
}
