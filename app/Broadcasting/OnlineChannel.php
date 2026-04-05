<?php

namespace App\Broadcasting;

use App\Models\User;

class OnlineChannel
{
    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, string $companyId): array|bool
    {
        if ($user->company_id !== (int) $companyId) {
            return false;
        }

        return ['user_id' => $user->user_id];
    }
}
