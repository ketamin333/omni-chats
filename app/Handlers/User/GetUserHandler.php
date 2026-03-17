<?php

namespace App\Handlers\User;

use App\Commands\User\GetUserCommand;
use App\Handlers\User\Contracts\GetUserHandlerInterface;
use App\Models\User;
use App\Repositories\UserRepository;

class GetUserHandler implements GetUserHandlerInterface
{
    /**
     * Handles GetUser action.
     */
    public function __construct(
        protected UserRepository $repository,
    ) {}

    public function handle(GetUserCommand $command): ?User
    {
        return $this->repository->findById($command);
    }
}
