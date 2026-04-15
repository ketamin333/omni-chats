<?php

namespace App\Handlers\Conversation\Contracts;

use App\Queries\Conversation\GetConversationsQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GetConversationsHandlerInterface
{
    public function handle(GetConversationsQuery $query): LengthAwarePaginator;
}
