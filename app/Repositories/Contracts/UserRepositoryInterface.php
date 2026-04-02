<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Queries\User\GetUserQuery;
use App\Queries\User\GetUsersQuery;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getPaginated(GetUsersQuery $query): LengthAwarePaginator;

    public function findById(GetUserQuery $query): User;
}
