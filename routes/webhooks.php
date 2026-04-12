<?php

use App\Http\Controllers\Webhooks\TelegramBotWebhookController;
use App\Http\Middleware\Webhooks\VerifyTelegramBotWebhookSecret;
use Illuminate\Support\Facades\Route;

Route::post('/telegram-bot/{channelTelegramBot}', TelegramBotWebhookController::class)
    ->middleware(VerifyTelegramBotWebhookSecret::class)
    ->name('webhook.telegram.bot');
