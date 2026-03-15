<?php

namespace App\Handlers\Auth\Contracts;

use App\Commands\Auth\LoginCommand;

interface LoginHandlerInterface
{
    public function handle(LoginCommand $command): bool;
}
