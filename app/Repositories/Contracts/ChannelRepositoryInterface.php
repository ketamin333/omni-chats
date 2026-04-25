<?php

namespace App\Repositories\Contracts;

use App\Models\Channel;
use App\Queries\Channel\GetChannelQuery;
use App\Queries\Channel\GetChannelsQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ChannelRepositoryInterface
{
    public function getPaginated(GetChannelsQuery $query): LengthAwarePaginator;
    public function findById(GetChannelQuery $query): Channel;
}
