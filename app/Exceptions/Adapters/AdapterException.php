<?php

namespace App\Exceptions\Adapters;

use RuntimeException;

class AdapterException extends RuntimeException
{
    public function __construct(
        string $message,
        protected readonly int $httpCode = 0,
    )
    {
        parent::__construct($message);
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
