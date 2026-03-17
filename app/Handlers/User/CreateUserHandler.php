<?php

namespace App\Handlers\User;

use App\Commands\User\CreateUserCommand;
use App\Events\UserCreated;
use App\Handlers\User\Contracts\CreateUserHandlerInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CreateUserHandler implements CreateUserHandlerInterface
{
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

                $user->assignRole($command->role);
                Event::dispatch(new UserCreated($user));

                return $user;
            });
        } catch (Throwable $e) {
            Storage::disk('public')->delete($avatar);

            throw $e;
        }
    }
}
