<?php

namespace App\Repositories\Contracts;

use App\Models\Channel;
use App\Models\Conversation;
use App\Queries\Conversation\GetConversationsQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ConversationRepositoryInterface
{
    public function getPaginated(GetConversationsQuery $query): LengthAwarePaginator;
    public function findByChannelAndExternalId(Channel $channel, int|string $externalId): ?Conversation;
}
