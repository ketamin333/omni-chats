<?php

namespace App\Repositories;

use App\Models\Adapter;
use App\Repositories\Contracts\AdapterRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AdapterRepository implements AdapterRepositoryInterface
{
    private const CACHE_KEY = 'providers';

    public function getAll(): Collection
    {
        return Cache::rememberForever(self::CACHE_KEY, fn() => Adapter::all());
    }

    public function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
