<?php

namespace App\Handlers\Permission\Contracts;

use App\Queries\Permission\GetPermissionsQuery;
use Illuminate\Support\Collection;

interface GetPermissionsHandlerInterface
{
    public function handle(GetPermissionsQuery $query): Collection;
}
