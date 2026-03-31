<?php

namespace App\Enums;

enum ChannelType: string
{
    case TELEGRAM_BOT = 'telegram:bot';
    case TELEGRAM_CLIENT = 'telegram:client';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
