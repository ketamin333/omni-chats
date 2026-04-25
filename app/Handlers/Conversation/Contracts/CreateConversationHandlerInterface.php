<?php

namespace App\Handlers\Conversation\Contracts;

use App\Commands\Conversation\CreateConversationCommand;
use App\Models\Conversation;

interface CreateConversationHandlerInterface
{
    public function handle(CreateConversationCommand $command): Conversation;
}
