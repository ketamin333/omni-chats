<?php

use App\Broadcasting\ChannelsChannel;
use App\Broadcasting\OnlineChannel;
use App\Broadcasting\UsersChannel;
use App\Enums\BroadcastChannel;
use Illuminate\Support\Facades\Broadcast;

/** USERS CHANNEL */
Broadcast::channel(BroadcastChannel::USERS->value, UsersChannel::class);

/** ONLINE CHANNEL */
Broadcast::channel(BroadcastChannel::ONLINE->value, OnlineChannel::class);

/** CHANNELS CHANNEL */
Broadcast::channel(BroadcastChannel::CHANNELS->value, ChannelsChannel::class);
