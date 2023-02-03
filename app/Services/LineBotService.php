<?php

namespace App\Services;

use App\Events\LineEvent;
use App\Events\MessageEvent;
use App\Events\PostbackEvent;
use App\Exceptions\LineBotPushException;
use LINE\LINEBot;
use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\Event\MessageEvent as LineMessageEvent;
use LINE\LINEBot\Event\PostbackEvent as LinePostbackEvent;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\MessageBuilder;

class LineBotService
{
    private LINEBot $bot;

    public function __construct(LINEBot $bot)
    {
        $this->bot = $bot;
    }

    /**
     * @throws InvalidSignatureException
     * @throws InvalidEventRequestException
     */
    public function parseRequestBody(string $body, string $signature): array
    {
        return $this->bot->parseEventRequest(
            $body,
            $signature
        );
    }

    private static function makeEventMap(BaseEvent $event): ?LineEvent
    {
        return match (true) {
            $event instanceof LineMessageEvent => new MessageEvent($event),
            $event instanceof LinePostbackEvent => new PostbackEvent($event),
            default => null,
        };
    }

    public static function dispatchEvents(array $events): void
    {
        foreach ($events as $event) {
            $mappedEvent = self::makeEventMap($event);

            if ($mappedEvent) {
                event($mappedEvent);
            }
        }
    }

    /**
     * @throws LineBotPushException
     */
    public function replyMessage($replyToken, MessageBuilder $messageBuilder): void
    {
        $response = $this->bot->replyMessage($replyToken, $messageBuilder);

        if (!$response->isSucceeded()) {
            throw new LineBotPushException($response->getRawBody());
        }
    }

    /**
     * @throws LineBotPushException
     */
    public function pushMessage(string $uid, MessageBuilder $messageBuilder): void
    {
        $response = $this->bot->pushMessage($uid, $messageBuilder);

        if (!$response->isSucceeded()) {
            throw new LineBotPushException($response->getRawBody());
        }
    }
}
