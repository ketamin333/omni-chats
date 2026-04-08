<?php

namespace App\Broadcasting;

use App\Enums\PermissionSlug;
use App\Models\User;

class ChannelsChannel
{
    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        return $user->hasPermission(PermissionSlug::CHANNELS_MANAGE);
    }
}
