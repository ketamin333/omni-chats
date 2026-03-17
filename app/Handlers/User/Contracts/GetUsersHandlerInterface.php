<?php

namespace App\Handlers\User\Contracts;

use App\Commands\User\GetUsersCommand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GetUsersHandlerInterface
{
    public function handle(GetUsersCommand $command): LengthAwarePaginator;
}
