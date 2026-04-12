<?php

namespace App\Exceptions\Adapters;

class AdapterConnectionException extends AdapterException
{
    public static function failed(int $status): self
    {
        return new self("Adapter connection failed with status $status");
    }
}
