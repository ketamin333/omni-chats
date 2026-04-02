<?php

namespace App\Repositories;

use App\Models\User;
use App\Queries\User\GetUserQuery;
use App\Queries\User\GetUsersQuery;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{

    public function getPaginated(GetUsersQuery $query): LengthAwarePaginator
    {
        return User::where('company_id', $query->companyId)
            ->paginate($query->perPage);
    }

    public function findById(GetUserQuery $query): User
    {
        return User::where('user_id', $query->userId)
            ->where('company_id', $query->companyId)
            ->firstOrFail();
    }
}
