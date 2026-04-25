<?php

namespace App\Handlers\Channel\Contracts;

use App\Models\Channel;
use App\Queries\Channel\GetChannelQuery;

interface GetChannelHandlerInterface
{
    public function handle(GetChannelQuery $query): ?Channel;
}
