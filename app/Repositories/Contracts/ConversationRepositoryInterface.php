<?php

namespace App\Repositories\Contracts;

use App\Models\Channel;
use App\Models\Conversation;

interface ConversationRepositoryInterface
{
    public function findByChannelAndExternalId(Channel $channel, int|string $externalId): ?Conversation;
}
