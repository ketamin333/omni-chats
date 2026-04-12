<?php

namespace App\Handlers\Channel\Contracts;

use App\Commands\Channel\UpdateCredentialsChannelCommand;
use App\Models\Channel;

interface UpdateCredentialsChannelHandlerInterface
{
    public function handle(UpdateCredentialsChannelCommand $command): Channel;
}
