<?php

namespace App\Handlers\User;

use App\Commands\User\UpdateAvatarUserCommand;
use App\Events\UserUpdated;
use App\Handlers\User\Contracts\UpdateUserAvatarHandlerInterface;
use App\Models\User;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Storage;

class UpdateAvatarUserHandler implements UpdateUserAvatarHandlerInterface
{
    public function __construct(
        protected Dispatcher $dispatcher,
    ) {}

    /**
     * Execute the UpdateUserAvatar action.
     */
    public function handle(UpdateAvatarUserCommand $command): User
    {
        $oldAvatar = $command->user->avatar;

        $avatar = $command->avatar->store('avatars', 'public');
        $command->user->update(['avatar' => $avatar]);

        if ($oldAvatar) {
            Storage::disk('public')->delete($oldAvatar);
        }

        $this->dispatcher->dispatch(new UserUpdated($command->user));

        return $command->user->refresh();
    }
}
