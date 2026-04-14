<?php

namespace App\Providers;

use App\Handlers\Adapter\Contracts\GetAdaptersHandlerInterface;
use App\Handlers\Adapter\GetAdaptersHandler;
use App\Repositories\AdapterRepository;
use App\Repositories\Contracts\AdapterRepositoryInterface;
use App\Services\Adapters\Telegram\Bot\Client\TelegramBotClient;
use App\Services\Adapters\Telegram\Bot\Client\TelegramBotClientInterface;
use Illuminate\Support\ServiceProvider;

class AdapterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** HANDLERS */
        $this->app->bind(GetAdaptersHandlerInterface::class, GetAdaptersHandler::class);

        /** REPOSITORIES */
        $this->app->bind(AdapterRepositoryInterface::class, AdapterRepository::class);

        /** CLIENTS */
        $this->app->bind(TelegramBotClientInterface::class, TelegramBotClient::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
