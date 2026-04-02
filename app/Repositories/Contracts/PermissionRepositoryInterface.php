<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface PermissionRepositoryInterface
{
    public function getAll(): Collection;

    public function getIdsBySlug(array $slugs): Collection;

    public function flush(): void;
}
