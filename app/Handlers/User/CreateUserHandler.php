<?php

namespace App\Handlers\User;

use App\Commands\User\CreateUserCommand;
use App\Events\UserCreated;
use App\Handlers\User\Contracts\CreateUserHandlerInterface;
use App\Handlers\User\Contracts\SyncUserPermissionsHandlerInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Events\Dispatcher;
use Throwable;

class CreateUserHandler implements CreateUserHandlerInterface
{
    public function __construct(
        protected SyncUserPermissionsHandlerInterface $syncUserPermissionsHandler,
        protected Dispatcher $dispatcher,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(CreateUserCommand $command): User
    {
        $avatar = $command->avatar?->store('avatars', 'public');

        try {
            return DB::transaction(function () use ($command, $avatar) {
                $user = User::create([
                    'company_id' => $command->companyId,
                    'username'   => $command->username,
                    'email'      => $command->email,
                    'password'   => $command->password,
                    'avatar'     => $avatar,
                    'phone'      => $command->phone,
                ]);

                $this->syncUserPermissionsHandler->handle($user, $command->permissions);

                $this->dispatcher->dispatch(new UserCreated($user));

                return $user;
            });
        } catch (Throwable $e) {
            Storage::disk('public')->delete($avatar);

            throw $e;
        }
    }
}
