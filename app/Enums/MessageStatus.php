<?php

namespace App\Enums;

enum MessageStatus: string
{
    case PENDING = 'pending';
    case SENT = 'sent';
    case FAILED = 'failed';
    case RECEIVED = 'received';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
