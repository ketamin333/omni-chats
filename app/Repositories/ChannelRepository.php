<?php

namespace App\Repositories;

use App\Models\Channel;
use App\Queries\Channel\GetChannelsQuery;
use App\Repositories\Contracts\ChannelRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ChannelRepository implements ChannelRepositoryInterface
{
    public function getPaginated(GetChannelsQuery $query): LengthAwarePaginator
    {
        return Channel::where('company_id', $query->companyId)
            ->paginate($query->perPage);
    }
}
