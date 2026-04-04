<?php

namespace App\Handlers\User\Contracts;

use App\Commands\User\UpdateUserAvatarCommand;
use App\Models\User;

interface UpdateUserAvatarHandlerInterface
{
    public function handle(UpdateUserAvatarCommand $command): User;
}
