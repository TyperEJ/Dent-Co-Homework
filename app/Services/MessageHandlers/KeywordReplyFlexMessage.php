<?php

namespace App\Services\MessageHandlers;

use Closure;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\MessageBuilder\RawMessageBuilder;

class KeywordReplyFlexMessage implements MessageEventHandler
{
    public function handle(MessageEvent $message, Closure $next)
    {
        if(
            $message instanceof TextMessage &&
            $message->getText() === '關鍵字'
        )
        {
            return self::getFlexMessage();
        }

        return  $next($message);
    }

    private static function getFlexMessageContentJson(): string
    {
        return <<<JSON
{
  "type": "bubble",
  "hero": {
    "type": "image",
    "url": "https://i.imgur.com/R0VEV2u.png",
    "size": "full",
    "aspectRatio": "20:13",
    "aspectMode": "cover",
    "action": {
      "type": "uri",
      "uri": "https://www.dentco.tw/"
    }
  },
  "footer": {
    "type": "box",
    "layout": "vertical",
    "spacing": "sm",
    "contents": [
      {
        "type": "button",
        "style": "link",
        "height": "sm",
        "action": {
          "type": "uri",
          "label": "Dent&Co",
          "uri": "https://www.dentco.tw/"
        }
      },
      {
        "type": "button",
        "style": "link",
        "height": "sm",
        "action": {
          "type": "postback",
          "label": "服務介紹",
          "data": "{\"type\":\"INTRODUCE\"}"
        }
      },
      {
        "type": "box",
        "layout": "vertical",
        "contents": [],
        "margin": "sm"
      }
    ],
    "flex": 0
  }
}
JSON;
    }

    private static function getFlexMessageWrap(): array
    {
        return [
            'type' => 'flex',
            'altText' => 'This is a Flex Message',
            'contents' => json_decode(
                self::getFlexMessageContentJson(),
                true
            )
        ];
    }

    private static function getFlexMessage(): RawMessageBuilder
    {
        return new RawMessageBuilder(
            self::getFlexMessageWrap()
        );
    }
}
