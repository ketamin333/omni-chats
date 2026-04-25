<?php

namespace App\Enums;

enum PermissionSlug: string
{
    case USERS_MANAGE = 'users.manage';
    case CHANNELS_MANAGE = 'channels.manage';
}
