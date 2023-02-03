<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\LineBotWebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [SystemController::class,'index'])->name('system.index');
Route::post('/', [SystemController::class,'pushMessage'])->name('system.push-message');

Route::post('/line-bot/webhook', [LineBotWebhookController::class,'index']);
