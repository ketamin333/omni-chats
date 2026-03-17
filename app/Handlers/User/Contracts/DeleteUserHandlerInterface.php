<?php

namespace App\Handlers\User\Contracts;

use App\Commands\User\DeleteUserCommand;

interface DeleteUserHandlerInterface
{
    public function handle(DeleteUserCommand $command): void;
}
