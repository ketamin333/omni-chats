<?php

namespace App\Handlers\User;

use App\Commands\User\DeleteUserCommand;
use App\Events\UserDeleted;
use App\Handlers\User\Contracts\DeleteUserHandlerInterface;
use Illuminate\Contracts\Events\Dispatcher;

class DeleteUserHandler implements DeleteUserHandlerInterface
{
    public function __construct(
        protected Dispatcher $dispatcher
    ) {}

    public function handle(DeleteUserCommand $command): void
    {
        $command->user->deleteOrFail();

        $this->dispatcher->dispatch(new UserDeleted($command->user));
    }
}
