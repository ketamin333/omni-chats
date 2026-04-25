<?php

namespace App\Providers;

use App\Handlers\Contact\Contracts\CreateContactHandlerInterface;
use App\Handlers\Contact\CreateContactHandler;
use Illuminate\Support\ServiceProvider;

class ContactServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** HANDLERS */
        $this->app->bind(CreateContactHandlerInterface::class, CreateContactHandler::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
