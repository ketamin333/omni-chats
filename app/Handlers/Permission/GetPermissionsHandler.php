<?php

namespace App\Handlers\Permission;

use App\Handlers\Permission\Contracts\GetPermissionsHandlerInterface;
use App\Queries\Permission\GetPermissionsQuery;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Support\Collection;

class GetPermissionsHandler implements GetPermissionsHandlerInterface
{
    /**
     * Handler for GetPermission action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        private readonly PermissionRepositoryInterface $repository,
    ) {}

    /**
     * Execute the GetPermission action.
     */
    public function handle(GetPermissionsQuery $query): Collection
    {
        return $this->repository->getAll();
    }
}
