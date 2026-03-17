<?php

namespace App\Handlers\User\Contracts;

use App\Commands\User\GetUserCommand;
use App\Models\User;

interface GetUserHandlerInterface
{
    public function handle(GetUserCommand $command): ?User;
}
