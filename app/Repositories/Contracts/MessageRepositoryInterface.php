<?php

namespace App\Repositories\Contracts;

use App\Queries\Message\GetMessagesQuery;
use Illuminate\Pagination\CursorPaginator;

interface MessageRepositoryInterface
{
    public function getPaginated(GetMessagesQuery $query): CursorPaginator;
}
