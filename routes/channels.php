<?php

use App\Broadcasting\ChannelsChannel;
use App\Broadcasting\ConversationsChannel;
use App\Broadcasting\OnlineChannel;
use App\Broadcasting\UsersChannel;
use Illuminate\Support\Facades\Broadcast;

/** USERS CHANNEL */
Broadcast::channel('users.{companyId}', UsersChannel::class);

/** ONLINE CHANNEL */
Broadcast::channel('online.{companyId}', OnlineChannel::class);

/** CHANNELS CHANNEL */
Broadcast::channel('channels.{companyId}', ChannelsChannel::class);

/** CONVERSATIONS CHANNEL */
Broadcast::channel('conversations.{conversationId}', ConversationsChannel::class);
