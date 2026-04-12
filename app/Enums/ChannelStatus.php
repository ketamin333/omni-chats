<?php

namespace App\Enums;

enum ChannelStatus: string
{
    // BASE STATES
    case PENDING = 'pending'; // CREATED
    case CONNECTING = 'connecting'; // CONNECTING

    // ACTIVE STATES
    case ACTIVE = 'active'; // ACTIVE

    // TIME PROBLEM STATES
    case PAUSED = 'paused'; // ON PAUSE
    case RATE_LIMITED = 'rate_limited'; // RATE BY API

    // ERRORS STATES
    case INVALID_CREDENTIALS = 'invalid_credentials'; // INVALID_CREDENTIALS
    case DISCONNECTED = 'disconnected'; // DISCONNECTED
    case BANNED = 'banned'; // BANNED

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function allowedTransitions(): array
    {
        return match ($this) {
            self::PENDING             => [self::CONNECTING],
            self::CONNECTING          => [self::ACTIVE, self::INVALID_CREDENTIALS, self::BANNED],
            self::ACTIVE              => [self::PAUSED, self::DISCONNECTED, self::RATE_LIMITED, self::BANNED],
            self::PAUSED              => [self::CONNECTING],
            self::DISCONNECTED        => [self::CONNECTING],
            self::INVALID_CREDENTIALS => [self::CONNECTING],
            default                   => [],
        };
    }

    public static function allowed(): array
    {
        return [self::PAUSED, self::CONNECTING];
    }
}
