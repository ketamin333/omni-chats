<?php

namespace App\Enums;

enum ChannelStatus: string
{
    // BASE STATES
    case PENDING = 'pending'; // CREATED
    case CONNECTING = 'connecting'; // CONNECTING
    case AUTHENTICATING = 'authenticating'; // AUTHENTICATING

    // ACTIVE STATES
    case AUTHENTICATED = 'authenticated';  // AUTHENTICATED
    case ACTIVE = 'active'; // ACTIVE

    // TIME PROBLEM STATES
    case PAUSED = 'paused'; // ON PAUSE
    case RATE_LIMITED = 'rate_limited'; // RATE BY API
    case RECONNECTING = 'reconnecting'; // TRYING TO RECONNECT

    // ERRORS STATES
    case INVALID_CREDENTIALS = 'invalid_credentials'; // INVALID_CREDENTIALS
    case EXPIRED = 'expired'; // SESSION EXPIRED

    // CRIT STATES
    case DISCONNECTED = 'disconnected'; // DISCONNECTED
    case BANNED = 'banned'; // BANNED

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
