<?php

namespace App\Handlers\User;

use App\Commands\User\UpdateUserCommand;
use App\Events\UserUpdated;
use App\Handlers\User\Contracts\SyncUserPermissionsHandlerInterface;
use App\Handlers\User\Contracts\UpdateUserHandlerInterface;
use App\Models\User;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateUserHandler implements UpdateUserHandlerInterface
{
    public function __construct(
        protected SyncUserPermissionsHandlerInterface $syncUserPermissionsHandler,
        protected Dispatcher $dispatcher,
    ) {}

    public function handle(UpdateUserCommand $command): User
    {
        return DB::transaction(function () use ($command) {
            $data = array_filter([
                'username' => $command->username,
                'phone'    => $command->phone,
            ], fn ($i) => $i !== null);

            if ($command->permissions !== null) {
                $this->syncUserPermissionsHandler->handle($command->user, $command->permissions);
            }

            $command->user->update($data);
            $this->dispatcher->dispatch(new UserUpdated($command->user));

            return $command->user->fresh();
        });
    }
}
