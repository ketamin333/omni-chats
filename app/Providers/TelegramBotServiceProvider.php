<?php

namespace App\Providers;

use App\Services\Adapters\Telegram\Bot\Client\TelegramBotClient;
use App\Services\Adapters\Telegram\Bot\Client\TelegramBotClientInterface;
use App\Services\Adapters\Telegram\Bot\Handlers\Contracts\TelegramBotChatMemberHandlerInterface;
use App\Services\Adapters\Telegram\Bot\Handlers\Contracts\TelegramBotMessageHandlerInterface;
use App\Services\Adapters\Telegram\Bot\Handlers\TelegramBotChatMemberHandler;
use App\Services\Adapters\Telegram\Bot\Handlers\TelegramBotMessageHandler;
use Illuminate\Support\ServiceProvider;

class TelegramBotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** CLIENTS */
        $this->app->bind(TelegramBotClientInterface::class, TelegramBotClient::class);

        /** HANDLERS */
        $this->app->bind(TelegramBotMessageHandlerInterface::class, TelegramBotMessageHandler::class);
        $this->app->bind(TelegramBotChatMemberHandlerInterface::class, TelegramBotChatMemberHandler::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
