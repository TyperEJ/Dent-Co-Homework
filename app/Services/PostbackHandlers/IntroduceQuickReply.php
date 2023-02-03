<?php

namespace App\Services\PostbackHandlers;

use Closure;
use Illuminate\Support\Arr;
use LINE\LINEBot\Event\PostbackEvent;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;

class IntroduceQuickReply implements PostbackEventHandler
{
    public function handle(PostbackEvent $message, Closure $next)
    {
        $data = json_decode($message->getPostbackData(),true);

        if(Arr::get($data,'type') === 'INTRODUCE')
        {
            return self::makeTextMessage();
        }

        return  $next($message);
    }

    private static function makeTextMessage(): TextMessageBuilder
    {
        return new TextMessageBuilder(
            '請選擇您需要的服務',
            new QuickReplyMessageBuilder([
                new QuickReplyButtonBuilder(
                    new MessageTemplateActionBuilder('矯正治療','矯正治療')
                ),
                new QuickReplyButtonBuilder(
                    new MessageTemplateActionBuilder('植牙治療','植牙治療')
                ),
                new QuickReplyButtonBuilder(
                    new MessageTemplateActionBuilder('美白/貼片','美白/貼片')
                ),
                new QuickReplyButtonBuilder(
                    new MessageTemplateActionBuilder('智齒拔除','智齒拔除')
                ),
                new QuickReplyButtonBuilder(
                    new MessageTemplateActionBuilder('根管治療','根管治療')
                ),
            ])
        );
    }
}
