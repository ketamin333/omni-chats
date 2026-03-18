<?php

namespace App\Queries\User;

readonly class GetUsersQuery
{
    /**
     * Data transfer object for GetUsers handler.
     */
    public function __construct(
        public int $companyId,
        public int $perPage = 25,
    ) {}
}
