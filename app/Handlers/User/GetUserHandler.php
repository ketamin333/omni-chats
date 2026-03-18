<?php

namespace App\Handlers\User;

use App\Handlers\User\Contracts\GetUserHandlerInterface;
use App\Models\User;
use App\Queries\User\GetUserQuery;
use App\Repositories\UserRepository;

class GetUserHandler implements GetUserHandlerInterface
{
    /**
     * Handles GetUser action.
     */
    public function __construct(
        protected UserRepository $repository,
    ) {}

    public function handle(GetUserQuery $query): ?User
    {
        return $this->repository->findById($query);
    }
}
