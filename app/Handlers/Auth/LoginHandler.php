<?php

namespace App\Handlers\Auth;

use App\Commands\Auth\LoginCommand;
use App\Handlers\Auth\Contracts\LoginHandlerInterface;
use Illuminate\Contracts\Auth\StatefulGuard;

class LoginHandler implements LoginHandlerInterface
{
    /**
     * Handles Login action.
     */
    public function __construct(
        protected StatefulGuard $guard,
    ) {}

    public function handle(LoginCommand $command): bool
    {
        return $this->guard->attempt([
            'email'    => $command->email,
            'password' => $command->password
        ], $command->remember);
    }
}
