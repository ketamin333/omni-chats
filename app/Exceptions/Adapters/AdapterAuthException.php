<?php

namespace App\Exceptions\Adapters;

class AdapterAuthException extends AdapterException
{
    public static function invalidCredentials(): self
    {
        return new self('Invalid adapter credentials');
    }
}
