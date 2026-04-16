<?php

namespace App\Handlers\Conversation\Contracts;

use App\Models\Conversation;
use App\Queries\Conversation\GetConversationQuery;

interface GetConversationHandlerInterface
{
    public function handle(GetConversationQuery $query): Conversation;
}
