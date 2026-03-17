<?php

namespace App\Commands\User;

use App\Models\User;

readonly class DeleteUserCommand
{
    /**
     * Data transfer object for DeleteUser handler.
     */
    public function __construct(
        public User $user
    ) {}
}
