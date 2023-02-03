<?php

namespace App\Services;

use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\RawMessageBuilder;

class SystemService
{
    public function makeMessage(string $title, string $content): MessageBuilder
    {
        return new RawMessageBuilder(
            $this->getFlexMessageWrap($title, $content)
        );
    }

    private function getFlexMessageWrap(string $title, string $content): array
    {
        return [
            'type' => 'flex',
            'altText' => 'This is a Flex Message',
            'contents' => json_decode(
                $this->flexMessageJson($title, $content),
                true
            )
        ];
    }

    private function flexMessageJson(string $title, string $content): string
    {
        return <<<Json
{
  "type": "bubble",
  "body": {
    "type": "box",
    "layout": "vertical",
    "contents": [
      {
        "type": "image",
        "url": "https://media.cnn.com/api/v1/images/stellar/prod/220327223559-29-oscars-show-2022.jpg?c=original",
        "size": "full",
        "aspectMode": "cover",
        "aspectRatio": "1:1",
        "gravity": "center"
      },
      {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "$title",
            "color": "#FFFFFF"
          }
        ],
        "width": "40%",
        "height": "10%",
        "position": "absolute",
        "offsetTop": "40%",
        "offsetStart": "10%",
        "backgroundColor": "#000000",
        "alignItems": "center",
        "justifyContent": "center"
      },
      {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "$content",
            "color": "#FFFFFF"
          }
        ],
        "position": "absolute",
        "width": "40%",
        "height": "10%",
        "offsetTop": "70%",
        "offsetStart": "50%",
        "justifyContent": "center",
        "alignItems": "center",
        "backgroundColor": "#000000"
      }
    ],
    "paddingAll": "0px"
  }
}
Json;

    }
}
