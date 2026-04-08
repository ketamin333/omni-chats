<?php

namespace App\Handlers\Channel;

use App\Handlers\Channel\Contracts\GetChannelsHandlerInterface;
use App\Queries\Channel\GetChannelsQuery;
use App\Repositories\Contracts\ChannelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetChannelsHandler implements GetChannelsHandlerInterface
{
    /**
     * Handler for GetChannels action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected ChannelRepositoryInterface $repository
    ) {}

    /**
     * Execute the GetChannels action.
     *
     * @param GetChannelsQuery $query
     * @return LengthAwarePaginator
     */
    public function handle(GetChannelsQuery $query): LengthAwarePaginator
    {
        return $this->repository->getPaginated($query);
    }
}
