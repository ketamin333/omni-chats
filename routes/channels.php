<?php

use App\Broadcasting\UsersChannel;
use App\Enums\BroadcastChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(BroadcastChannel::USER->value, UsersChannel::class);
