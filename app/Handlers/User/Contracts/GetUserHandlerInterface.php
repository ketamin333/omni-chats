<?php

namespace App\Handlers\User\Contracts;

use App\Models\User;
use App\Queries\User\GetUserQuery;

interface GetUserHandlerInterface
{
    public function handle(GetUserQuery $query): ?User;
}
