<?php

namespace App\Repositories\Contracts;

use App\Queries\Channel\GetChannelsQuery;
use Illuminate\Pagination\LengthAwarePaginator;

interface ChannelRepositoryInterface
{
    public function getPaginated(GetChannelsQuery $query): LengthAwarePaginator;
}
