<?php

namespace App\Handlers\Conversation;

use App\Handlers\Conversation\Contracts\GetConversationsHandlerInterface;
use App\Queries\Conversation\GetConversationsQuery;
use App\Repositories\Contracts\ConversationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class GetConversationsHandler implements GetConversationsHandlerInterface
{
    /**
     * Handler for GetConversations action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected ConversationRepositoryInterface $repository
    ) {}

    /**
     * Execute the GetConversations action.
     */
    public function handle(GetConversationsQuery $query): LengthAwarePaginator
    {
        return $this->repository->getPaginated($query);
    }
}
