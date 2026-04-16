<?php

namespace App\Handlers\Message;

use App\Handlers\Message\Contracts\GetMessagesHandlerInterface;
use App\Queries\Message\GetMessagesQuery;
use App\Repositories\Contracts\MessageRepositoryInterface;
use Illuminate\Pagination\CursorPaginator;

class GetMessagesHandler implements GetMessagesHandlerInterface
{
    /**
     * Handler for GetMessagesQuery action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected MessageRepositoryInterface $repository,
    ) {}

    /**
     * Execute the GetMessagesQuery action.
     */
    public function handle(GetMessagesQuery $query): CursorPaginator
    {
        return $this->repository->getPaginated($query);
    }
}
