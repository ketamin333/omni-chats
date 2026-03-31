<?php

namespace App\Handlers\Channel\Contracts;

use App\Commands\Channel\CreateChannelCommand;
use App\Models\Channel;

interface CreateChannelHandlerInterface
{
    public function handle(CreateChannelCommand $command): Channel;
}
