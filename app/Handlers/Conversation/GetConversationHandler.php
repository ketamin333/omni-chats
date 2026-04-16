<?php

namespace App\Handlers\Conversation;

use App\Handlers\Conversation\Contracts\GetConversationHandlerInterface;
use App\Models\Conversation;
use App\Queries\Conversation\GetConversationQuery;
use App\Repositories\Contracts\ConversationRepositoryInterface;

class GetConversationHandler implements GetConversationHandlerInterface
{
    /**
     * Handler for GetConversation action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected ConversationRepositoryInterface $repository
    ) {}

    /**
     * Execute the GetConversation action.
     */
    public function handle(GetConversationQuery $query): Conversation
    {
        return $this->repository->findById($query);
    }
}
