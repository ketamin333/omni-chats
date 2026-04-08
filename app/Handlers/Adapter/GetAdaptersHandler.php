<?php

namespace App\Handlers\Adapter;

use App\Handlers\Adapter\Contracts\GetAdaptersHandlerInterface;
use App\Queries\Adapter\GetAdaptersQuery;
use App\Repositories\Contracts\AdapterRepositoryInterface;
use Illuminate\Support\Collection;

class GetAdaptersHandler implements GetAdaptersHandlerInterface
{
    /**
     * Handler for GetAdapters action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected readonly AdapterRepositoryInterface $repository
    ) {}

    /**
     * Execute the GetAdapters action.
     */
    public function handle(GetAdaptersQuery $query): Collection
    {
        return $this->repository->getAll();
    }
}
