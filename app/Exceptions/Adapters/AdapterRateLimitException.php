<?php

namespace App\Exceptions\Adapters;

class AdapterRateLimitException extends AdapterException
{
    public static function tooManyRequests(): self
    {
        return new self('Adapter rate limit exceeded');
    }
}
