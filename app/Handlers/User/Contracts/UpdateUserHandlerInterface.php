<?php

namespace App\Handlers\User\Contracts;

use App\Commands\User\UpdateUserCommand;
use App\Models\User;

interface UpdateUserHandlerInterface
{
    public function handle(UpdateUserCommand $command): User;
}
