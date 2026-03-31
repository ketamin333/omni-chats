<?php

namespace App\Enums;

enum MessageType: string
{
    case INCOMING = 'incoming';
    case OUTGOING = 'outgoing';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
