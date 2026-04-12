<?php

namespace App\Handlers\Channel\Contracts;

use App\Commands\Channel\UpdateStatusChannelCommand;
use App\Models\Channel;

interface UpdateStatusChannelHandlerInterface
{
    public function handle(UpdateStatusChannelCommand $command): Channel;
}
