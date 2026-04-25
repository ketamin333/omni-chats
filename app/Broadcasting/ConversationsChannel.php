<?php

namespace App\Broadcasting;

use App\Models\Conversation;
use App\Models\User;

class ConversationsChannel
{
    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, string $conversationId): array|bool
    {
        $conversation = Conversation::whereHas('channel', fn($q) =>
            $q->where('company_id', $user->company_id)
        )->find($conversationId);

        return (bool) $conversation;
    }
}
