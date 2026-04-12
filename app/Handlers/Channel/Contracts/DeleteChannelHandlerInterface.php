<?php

namespace App\Handlers\Channel\Contracts;

use App\Commands\Channel\CreateChannelCommand;
use App\Commands\Channel\DeleteChannelCommand;

interface DeleteChannelHandlerInterface
{
    public function handle(DeleteChannelCommand $command): void;
}
