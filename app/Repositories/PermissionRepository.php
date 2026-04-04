<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PermissionRepository implements PermissionRepositoryInterface
{
    private const CACHE_KEY = 'permissions';

    public function getAll(): Collection
    {
        return Cache::rememberForever(self::CACHE_KEY, fn() => Permission::all());
    }

    public function getIdsBySlug(array $slugs): Collection
    {
        return $this->getAll()
            ->filter(fn($p) => in_array($p->slug->value, $slugs))
            ->pluck('permission_id');
    }

    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
