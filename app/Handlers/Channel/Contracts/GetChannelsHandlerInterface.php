<?php

namespace App\Handlers\Channel\Contracts;

use App\Queries\Channel\GetChannelsQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GetChannelsHandlerInterface
{
    public function handle(GetChannelsQuery $query): LengthAwarePaginator;
}
