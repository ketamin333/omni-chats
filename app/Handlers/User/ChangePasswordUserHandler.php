<?php

namespace App\Handlers\User;

use App\Commands\User\ChangePasswordUserCommand;
use App\Handlers\User\Contracts\ChangePasswordUserHandlerInterface;
use Illuminate\Support\Facades\Hash;

class ChangePasswordUserHandler implements ChangePasswordUserHandlerInterface
{
    /**
     * Execute the ChangePasswordUser action.
     */
    public function handle(ChangePasswordUserCommand $command): void
    {
        $command->user->update(['password' => Hash::make($command->password)]);
        $command->user->tokens()->delete();
    }
}
