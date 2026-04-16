<?php

namespace App\Repositories;

use App\Models\Channel;
use App\Models\Conversation;
use App\Queries\Conversation\GetConversationQuery;
use App\Queries\Conversation\GetConversationsQuery;
use App\Repositories\Contracts\ConversationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ConversationRepository implements ConversationRepositoryInterface
{
    public function getPaginated(GetConversationsQuery $query): LengthAwarePaginator
    {
        return Conversation::whereHas('channel', function ($q) use ($query) {
            $q->where('company_id', $query->companyId);
        })
            ->with(['contact', 'channel', 'lastMessage'])
            ->latest()
            ->paginate($query->perPage);
    }

    public function findById(GetConversationQuery $query): Conversation
    {
        return Conversation::whereHas('channel', function ($q) use ($query) {
            $q->where('company_id', $query->companyId);
        })
            ->where('conversation_id', $query->conversationId)
            ->firstOrFail();
    }

    public function findByChannelAndExternalId(Channel $channel, int|string $externalId): ?Conversation
    {
        return $channel->conversations()
            ->where('external_id', $externalId)
            ->first();
    }
}
