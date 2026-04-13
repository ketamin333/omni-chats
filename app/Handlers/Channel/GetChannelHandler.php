<?php

namespace App\Handlers\Channel;

use App\Handlers\Channel\Contracts\GetChannelHandlerInterface;
use App\Models\Channel;
use App\Queries\Channel\GetChannelQuery;
use App\Repositories\Contracts\ChannelRepositoryInterface;

class GetChannelHandler implements GetChannelHandlerInterface
{
    /**
     * Handler for GetChannel action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected ChannelRepositoryInterface $repository,
    ) {}

    /**
     * Execute the GetChannel action.
     */
    public function handle(GetChannelQuery $query): Channel
    {
        return $this->repository->findById($query);
    }
}
