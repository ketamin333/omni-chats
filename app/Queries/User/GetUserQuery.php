<?php

namespace App\Queries\User;

readonly class GetUserQuery
{
    public function __construct(
        public int $userId,
        public int $companyId,
    ) {}
}
