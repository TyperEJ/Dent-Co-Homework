<?php

namespace App\Listeners;

use App\Events\PostbackEvent;
use App\Exceptions\LineBotPushException;
use App\Services\LineBotService;
use App\Services\PostbackHandlers\IntroduceQuickReply;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\MessageBuilder;

class PostbackHandler
{
    private array $pipes = [
        IntroduceQuickReply::class,
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
     * @param PostbackEvent $event
     * @return void
     * @throws LineBotPushException
     */
    public function handle(PostbackEvent $event): void
    {
        $message = app(Pipeline::class)
            ->send($event->getPostback())
            ->through($this->pipes)
            ->thenReturn();

        if ($message instanceof MessageBuilder) {
            $this->lineBotService->replyMessage($event->getReplyToken(), $message);
        }
    }
}
