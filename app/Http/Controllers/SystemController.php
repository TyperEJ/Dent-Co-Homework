<?php

namespace App\Http\Controllers;

use App\Exceptions\LineBotPushException;
use App\Services\LineBotService;
use App\Services\SystemService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SystemController extends Controller
{
    public function index(): View
    {
        return view('system');
    }

    /**
     * @throws LineBotPushException
     */
    public function pushMessage(
        Request        $request,
        SystemService  $systemService,
        LineBotService $lineBotService
    ): RedirectResponse
    {
        $request->validate([
            'uid' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        $message = $systemService->makeMessage(
            $request->input('title'),
            $request->input('content')
        );

        $lineBotService->pushMessage($request->input('uid'), $message);

        return redirect()->route('system.index');
    }
}
