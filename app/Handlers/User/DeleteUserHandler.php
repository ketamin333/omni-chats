<?php

namespace App\Handlers\User;

use App\Commands\User\DeleteUserCommand;
use App\Events\UserDeleted;
use App\Handlers\User\Contracts\DeleteUserHandlerInterface;
use Illuminate\Support\Facades\Event;

class DeleteUserHandler implements DeleteUserHandlerInterface
{
    public function handle(DeleteUserCommand $command): void
    {
        $command->user->deleteOrFail();

        Event::dispatch(new UserDeleted($command->user));
    }
}
