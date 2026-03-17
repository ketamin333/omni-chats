<?php

namespace App\Commands\User;

readonly class GetUserCommand
{
    /**
     * Data transfer object for GetUser handler.
     */
    public function __construct(
        public int $userId,
        public int $companyId,
    ) {}
}
