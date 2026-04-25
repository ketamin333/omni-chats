<?php

namespace App\Providers;

use App\Handlers\Attachment\Contracts\CreateAttachmentHandlerInterface;
use App\Handlers\Attachment\CreateAttachmentHandler;
use Illuminate\Support\ServiceProvider;

class AttachmentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** HANDLERS */
        $this->app->bind(CreateAttachmentHandlerInterface::class, CreateAttachmentHandler::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
