<?php

namespace App\Exceptions\Adapters;

class AdapterRateLimitException extends AdapterException
{
    public function __construct(
        public readonly int $retryAfter,
    ) {
        parent::__construct("Rate limit exceeded. Retry after {$retryAfter} seconds.");
    }
}
