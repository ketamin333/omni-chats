<?php

namespace App\Handlers\User;

use App\Commands\User\GetUsersCommand;
use App\Handlers\User\Contracts\GetUsersHandlerInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetUsersHandler implements GetUsersHandlerInterface
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {}

    public function handle(GetUsersCommand $command): LengthAwarePaginator
    {
        return $this->repository->getPaginated($command);
    }
}
