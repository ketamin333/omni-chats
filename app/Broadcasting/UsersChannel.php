<?php

namespace App\Broadcasting;

use App\Enums\PermissionSlug;
use App\Models\User;

class UsersChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct() {}

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, string $companyId): array|bool
    {
        if ($user->company_id !== (int) $companyId) {
            return false;
        }

        return $user->hasPermission(PermissionSlug::USERS_MANAGE);
    }
}
