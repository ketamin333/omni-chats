<?php

namespace App\Enums;

enum MessageDirection: string
{
    case INCOMING = 'incoming';
    case OUTGOING = 'outgoing';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
