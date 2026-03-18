<?php

namespace App\Handlers\User;

use App\Handlers\User\Contracts\GetUsersHandlerInterface;
use App\Queries\User\GetUsersQuery;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetUsersHandler implements GetUsersHandlerInterface
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {}

    public function handle(GetUsersQuery $query): LengthAwarePaginator
    {
        return $this->repository->getPaginated($query);
    }
}
