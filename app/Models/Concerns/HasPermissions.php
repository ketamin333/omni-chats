<?php

namespace App\Models\Concerns;

use App\Enums\PermissionSlug;
use App\Models\Permission;
use Illuminate\Support\Collection;

/**
 * @property Collection<Permission> $permissions
 * @method bool relationLoaded(string $relation)
 * @method self load(array|string $relations)
 */
trait HasPermissions
{
    public function hasPermission(PermissionSlug|string $slug): bool
    {
        if (!$this->relationLoaded('permissions')) {
            $this->load('permissions');
        }

        $value = $slug instanceof PermissionSlug ? $slug->value : $slug;

        return $this->permissions->contains('slug', $value);
    }
}
