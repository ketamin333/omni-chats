<?php

namespace App\Handlers\User\Contracts;

use App\Commands\User\ChangePasswordUserCommand;

interface ChangePasswordUserHandlerInterface
{
    public function handle(ChangePasswordUserCommand $command): void;
}
