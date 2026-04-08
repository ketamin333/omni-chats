<?php

namespace App\Providers;

use App\Handlers\Channel\Contracts\CreateChannelHandlerInterface;
use App\Handlers\Channel\Contracts\GetChannelsHandlerInterface;
use App\Handlers\Channel\CreateChannelHandler;
use App\Handlers\Channel\GetChannelsHandler;
use App\Repositories\ChannelRepository;
use App\Repositories\Contracts\ChannelRepositoryInterface;
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
        $this->app->bind(CreateChannelHandlerInterface::class, CreateChannelHandler::class);

        /** REPOSITORIES */
        $this->app->bind(ChannelRepositoryInterface::class, ChannelRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
