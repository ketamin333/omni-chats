<?php

namespace App\Repositories;

use App\Models\Channel;
use App\Queries\Channel\GetChannelQuery;
use App\Queries\Channel\GetChannelsQuery;
use App\Repositories\Contracts\ChannelRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ChannelRepository implements ChannelRepositoryInterface
{
    public function getPaginated(GetChannelsQuery $query): LengthAwarePaginator
    {
        return Channel::where('company_id', $query->companyId)
            ->with(['adapter'])
            ->paginate($query->perPage);
    }

    public function findById(GetChannelQuery $query): Channel
    {
        return Channel::where('channel_id', $query->channelId)
            ->where('company_id', $query->companyId)
            ->firstOrFail();
    }
}
