<?php

namespace App\Services\Channels;

use App\Models\Channel;

interface ChannelServiceInterface
{
    public function check(array $credentials): void;
    public function setup(Channel $channel): void;
}
