<?php

namespace App\Repositories;

use App\Models\Channel;
use App\Models\Conversation;
use App\Repositories\Contracts\ConversationRepositoryInterface;

class ConversationRepository implements ConversationRepositoryInterface
{
    public function findByChannelAndExternalId(Channel $channel, int|string $externalId): ?Conversation
    {
        return $channel->conversations()
            ->where('external_id', $externalId)
            ->first();
    }
}
