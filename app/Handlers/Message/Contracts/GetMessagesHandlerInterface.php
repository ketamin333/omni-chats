<?php

namespace App\Handlers\Message\Contracts;

use App\Queries\Message\GetMessagesQuery;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface GetMessagesHandlerInterface
{
    public function handle(GetMessagesQuery $query): CursorPaginator;
}
