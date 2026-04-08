<?php

namespace App\Handlers\Adapter\Contracts;

use App\Queries\Adapter\GetAdaptersQuery;
use Illuminate\Support\Collection;

interface GetAdaptersHandlerInterface
{
    public function handle(GetAdaptersQuery $query): Collection;
}
