<?php

namespace App\Commands\User;

readonly class GetUsersCommand
{
    /**
     * Data transfer object for GetUsers handler.
     */
    public function __construct(
        public int $companyId,
        public int $perPage = 15,
    ) {}
}
