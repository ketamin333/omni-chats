<?php

namespace App\Handlers\User\Contracts;

use App\Queries\User\GetUsersQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GetUsersHandlerInterface
{
    public function handle(GetUsersQuery $query): LengthAwarePaginator;
}
