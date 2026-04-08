<?php

namespace App\Providers;

use App\Handlers\Channel\Contracts\GetChannelProvidersHandlerInterface;
use App\Handlers\Channel\GetChannelProvidersHandler;
use App\Repositories\ChannelProviderRepository;
use App\Repositories\ChannelProviderTypeRepository;
use App\Repositories\Contracts\ChannelProviderRepositoryInterface;
use App\Repositories\Contracts\ChannelProviderTypeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ChannelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** HANDLERS */
//        $this->app->bind(CreateChannelHandlerInterface::class, CreateChannelHandler::class);
        $this->app->bind(GetChannelProvidersHandlerInterface::class, GetChannelProvidersHandler::class);


        /** REPOSITORIES */

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
