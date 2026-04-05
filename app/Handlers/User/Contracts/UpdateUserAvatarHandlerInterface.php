<?php

namespace App\Handlers\User\Contracts;

use App\Commands\User\UpdateAvatarUserCommand;
use App\Models\User;

interface UpdateUserAvatarHandlerInterface
{
    public function handle(UpdateAvatarUserCommand $command): User;
}
