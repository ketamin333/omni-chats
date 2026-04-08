<?php

namespace App\Enums;

enum BroadcastChannel: string
{
    case USERS = 'users';
    case ONLINE = 'online.{companyId}';
    case CHANNELS = 'channels';
}
