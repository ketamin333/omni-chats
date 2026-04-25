<?php

namespace App\Enums;

enum AdapterType: string
{
    case BOT = 'bot';
    case BUSINESS = 'business';
    case GREEN_API = 'green_api';
}
