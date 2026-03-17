<?php

namespace App\Handlers\User\Contracts;

use App\Commands\User\CreateUserCommand;
use App\Models\User;

interface CreateUserHandlerInterface
{
    public function handle(CreateUserCommand $command): User;
}
