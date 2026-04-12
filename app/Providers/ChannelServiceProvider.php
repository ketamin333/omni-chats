<?php

namespace App\Providers;

use App\Events\ChannelCreated;
use App\Events\ChannelUpdated;
use App\Handlers\Channel\Contracts\CreateChannelHandlerInterface;
use App\Handlers\Channel\Contracts\DeleteChannelHandlerInterface;
use App\Handlers\Channel\Contracts\GetChannelHandlerInterface;
use App\Handlers\Channel\Contracts\GetChannelsHandlerInterface;
use App\Handlers\Channel\Contracts\UpdateCredentialsChannelHandlerInterface;
use App\Handlers\Channel\Contracts\UpdateStatusChannelHandlerInterface;
use App\Handlers\Channel\CreateChannelHandler;
use App\Handlers\Channel\DeleteChannelHandler;
use App\Handlers\Channel\GetChannelHandler;
use App\Handlers\Channel\GetChannelsHandler;
use App\Handlers\Channel\UpdateCredentialsChannelHandler;
use App\Handlers\Channel\UpdateStatusChannelHandler;
use App\Listeners\Channel\ChangedStatusChannelListener;
use App\Repositories\ChannelRepository;
use App\Repositories\Contracts\ChannelRepositoryInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class ChannelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** HANDLERS */
        $this->app->bind(GetChannelsHandlerInterface::class, GetChannelsHandler::class);
        $this->app->bind(GetChannelHandlerInterface::class, GetChannelHandler::class);
        $this->app->bind(CreateChannelHandlerInterface::class, CreateChannelHandler::class);
        $this->app->bind(UpdateStatusChannelHandlerInterface::class, UpdateStatusChannelHandler::class);
        $this->app->bind(UpdateCredentialsChannelHandlerInterface::class, UpdateCredentialsChannelHandler::class);
        $this->app->bind(DeleteChannelHandlerInterface::class, DeleteChannelHandler::class);

        /** REPOSITORIES */
        $this->app->bind(ChannelRepositoryInterface::class, ChannelRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /** EVENTS */
        Event::listen([ChannelCreated::class, ChannelUpdated::class], ChangedStatusChannelListener::class);
    }
}
