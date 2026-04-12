<?php

namespace App\Repositories\Contracts;

use App\Models\Adapter;
use App\Services\Adapters\Contracts\AdapterHandlerInterface;
use Illuminate\Support\Collection;

interface AdapterRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $adapterId): ?Adapter;

    public function forget(): void;
}
