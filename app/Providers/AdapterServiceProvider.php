<?php

namespace App\Providers;

use App\Handlers\Adapter\Contracts\GetAdaptersHandlerInterface;
use App\Handlers\Adapter\GetAdaptersHandler;
use App\Repositories\Contracts\AdapterRepositoryInterface;
use App\Repositories\AdapterRepository;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
