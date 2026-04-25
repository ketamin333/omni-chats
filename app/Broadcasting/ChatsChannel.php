<?php

namespace App\Broadcasting;

use App\Models\User;

class ChatsChannel
{
    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, string $companyId): array|bool
    {
        return $user->company_id === (int) $companyId;
    }
}
