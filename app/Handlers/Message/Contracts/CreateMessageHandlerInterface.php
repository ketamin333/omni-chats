<?php

namespace App\Handlers\Message\Contracts;

use App\Commands\Message\CreateMessageCommand;
use App\Models\Message;

interface CreateMessageHandlerInterface
{
    public function handle(CreateMessageCommand $command): Message;
}
