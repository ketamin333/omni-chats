<?php

namespace App\Providers;

use App\Handlers\Message\Contracts\CreateMessageHandlerInterface;
use App\Handlers\Message\CreateMessageHandler;
use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** HANDLERS */
        $this->app->bind(CreateMessageHandlerInterface::class, CreateMessageHandler::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
