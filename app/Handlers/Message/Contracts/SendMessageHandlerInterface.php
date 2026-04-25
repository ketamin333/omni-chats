<?php

namespace App\Handlers\Message\Contracts;

use App\Commands\Message\SendMessageCommand;
use App\Models\Message;

interface SendMessageHandlerInterface
{
    public function handle(SendMessageCommand $command): Message;
}
