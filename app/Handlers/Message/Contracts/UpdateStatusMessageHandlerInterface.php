<?php

namespace App\Handlers\Message\Contracts;

use App\Commands\Message\UpdateStatusMessageCommand;
use App\Models\Message;

interface UpdateStatusMessageHandlerInterface
{
    public function handle(UpdateStatusMessageCommand $command): Message;
}
