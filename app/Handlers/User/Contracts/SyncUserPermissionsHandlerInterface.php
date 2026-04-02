<?php

namespace App\Handlers\User\Contracts;

use App\Models\User;

interface SyncUserPermissionsHandlerInterface
{
    public function handle(User $user, array $slugs): array;
}
