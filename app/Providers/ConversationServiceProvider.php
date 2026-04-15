<?php

namespace App\Providers;

use App\Handlers\Conversation\Contracts\CreateConversationHandlerInterface;
use App\Handlers\Conversation\Contracts\GetConversationsHandlerInterface;
use App\Handlers\Conversation\CreateConversationHandler;
use App\Repositories\Contracts\ConversationRepositoryInterface;
use App\Repositories\ConversationRepository;
use Illuminate\Support\ServiceProvider;

class ConversationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** HANDLERS */
        $this->app->bind(GetConversationsHandlerInterface::class, CreateConversationHandler::class);
        $this->app->bind(CreateConversationHandlerInterface::class, CreateConversationHandler::class);

        /** REPOSITORIES */
        $this->app->bind(ConversationRepositoryInterface::class, ConversationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
