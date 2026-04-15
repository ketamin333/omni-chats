<?php

namespace App\Providers;

use App\Events\OutgoingMessageCreated;
use App\Handlers\Message\Contracts\CreateMessageHandlerInterface;
use App\Handlers\Message\Contracts\SendMessageHandlerInterface;
use App\Handlers\Message\Contracts\UpdateStatusMessageHandlerInterface;
use App\Handlers\Message\CreateMessageHandler;
use App\Handlers\Message\SendMessageHandler;
use App\Handlers\Message\UpdateStatusMessageHandler;
use App\Listeners\Message\DeliverOutgoingMessageListener;
use Illuminate\Support\Facades\Event;
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
        $this->app->bind(SendMessageHandlerInterface::class, SendMessageHandler::class);
        $this->app->bind(UpdateStatusMessageHandlerInterface::class, UpdateStatusMessageHandler::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(OutgoingMessageCreated::class, DeliverOutgoingMessageListener::class);
    }
}
