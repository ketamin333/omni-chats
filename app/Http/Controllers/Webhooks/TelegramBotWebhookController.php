<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTelegramBotUpdateJob;
use App\Models\Channel;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotUpdate;
use App\Support\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TelegramBotWebhookController extends Controller
{
    public function __construct(
        private readonly Dispatcher $bus,
    ) {}

    public function __invoke(Request $request, Channel $channelTelegramBot): Response
    {
        $this->bus->dispatch(
            new ProcessTelegramBotUpdateJob(
                $channelTelegramBot,
                new TelegramBotUpdate($request->collect())
            )
        );

        return ApiResponse::noContent();
    }
}
