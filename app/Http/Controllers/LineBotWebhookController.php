<?php

namespace App\Http\Controllers;

use App\Services\LineBotService;
use Illuminate\Http\Request;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\Exception\InvalidEventRequestException;

class LineBotWebhookController extends Controller
{
    public function index(Request $request,LineBotService $lineBotService)
    {
        if(!$request->hasHeader(HTTPHeader::LINE_SIGNATURE))
        {
            return abort(400);
        }

        try {
            $events = $lineBotService->parseRequestBody(
                $request->getContent(),
                $request->header(HTTPHeader::LINE_SIGNATURE)
            );
        } catch (InvalidSignatureException $e) {
            return abort(400,"Invalid signature");
        } catch (InvalidEventRequestException $e) {
            return abort(400,"Invalid event request");
        }

        LineBotService::dispatchEvents($events);
    }
}
