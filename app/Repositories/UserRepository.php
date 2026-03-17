<?php

namespace App\Repositories;

use App\Commands\User\GetUserCommand;
use App\Commands\User\GetUsersCommand;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{

    public function getPaginated(GetUsersCommand $command): LengthAwarePaginator
    {
        return User::where('company_id', $command->companyId)
            ->paginate($command->perPage);
    }


    public function findById(GetUserCommand $command): User
    {
        return User::where('user_id', $command->userId)
            ->where('company_id', $command->companyId)
            ->firstOrFail();
    }
}
