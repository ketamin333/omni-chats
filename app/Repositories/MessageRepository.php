<?php

namespace App\Repositories;

use App\Models\Message;
use App\Queries\Message\GetMessagesQuery;
use App\Repositories\Contracts\MessageRepositoryInterface;
use Illuminate\Pagination\CursorPaginator;

class MessageRepository implements MessageRepositoryInterface
{

    public function getPaginated(GetMessagesQuery $query): CursorPaginator
    {
        return Message::where('conversation_id', $query->conversation->converstation_id)
            ->with('attachments')
            ->orderBy('created_at', 'desc')
            ->cursorPaginate($query->perPage, cursor: $query->cursor);
    }
}
