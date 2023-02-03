<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class LineBotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LINEBot::class, function ($app) {
            $httpClient = new CurlHTTPClient(config('services.line_bot.access_token'));

            return new LINEBot($httpClient, [
                'channelSecret' => config('services.line_bot.channel_secret')
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
