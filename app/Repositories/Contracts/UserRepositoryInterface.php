<?php

namespace App\Repositories\Contracts;

use App\Commands\User\GetUserCommand;
use App\Commands\User\GetUsersCommand;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getPaginated(GetUsersCommand $command): LengthAwarePaginator;

    public function findById(GetUserCommand $command): User;
}
