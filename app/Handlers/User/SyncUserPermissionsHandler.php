<?php

namespace App\Handlers\User;

use App\Handlers\User\Contracts\SyncUserPermissionsHandlerInterface;
use App\Models\User;
use App\Repositories\Contracts\PermissionRepositoryInterface;

class SyncUserPermissionsHandler implements SyncUserPermissionsHandlerInterface
{
    /**
     * Handler for SyncUserPermissions action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected PermissionRepositoryInterface $permissionRepository,
    ) {}

    /**
     * Execute the SyncUserPermissions action.
     */
    public function handle(User $user, array $slugs): array
    {
        return $user->permissions()->sync(
            $this->permissionRepository->getIdsBySlug($slugs)
        );
    }
}
