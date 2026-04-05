<?php

namespace App\Providers;

use App\Handlers\Channel\Contracts\CreateChannelHandlerInterface;
use App\Handlers\Channel\CreateChannelHandler;
use Illuminate\Support\ServiceProvider;

class ChannelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** HANDLERS */
        $this->app->bind(CreateChannelHandlerInterface::class, CreateChannelHandler::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
