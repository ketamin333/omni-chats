<?php

namespace App\Handlers\Message\Contracts;

use App\Commands\Message\UpdateMessageCommand;
use App\Models\Message;

interface UpdateMessageHandlerInterface
{
    public function handle(UpdateMessageCommand $command): Message;
}
