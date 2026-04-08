<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface AdapterRepositoryInterface
{
    public function getAll(): Collection;

    public function forget(): void;
}
