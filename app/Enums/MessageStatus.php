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

    public function allowedTransitions(): array
    {
        return match ($this) {
            self::PENDING             => [self::SENT, self::FAILED],
            self::FAILED              => [self::PENDING],
            default                   => [],
        };
    }
}
