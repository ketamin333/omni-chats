<?php

namespace App\Handlers\User;

use App\Commands\User\UpdateUserCommand;
use App\Events\UserUpdated;
use App\Handlers\User\Contracts\UpdateUserHandlerInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UpdateUserHandler implements UpdateUserHandlerInterface
{
    public function handle(UpdateUserCommand $command): User
    {
        return DB::transaction(function () use ($command) {
            $data = array_filter([
                'username' => $command->username,
                'phone'    => $command->phone,
                'password' => $command->password ? Hash::make($command->password) : null,
            ], fn ($i) => $i !== null);

            if ($command->avatar) {
                if ($command->user->avatar !== User::DEFAULT_AVATAR) {
                    Storage::disk('public')->delete($command->user->avatar);
                }

                $data['avatar'] = $command->avatar->store('avatars', 'public');
            }

            if ($command->role) {
                $command->user->syncRoles($command->role);
            }

            $command->user->update($data);
            Event::dispatch(new UserUpdated($command->user));

            return $command->user->fresh();
        });
    }
}
