<?php

namespace App\Services\Adapters\Contracts;

use App\Enums\ChannelStatus;
use App\Exceptions\Adapters\AdapterException;
use Throwable;

interface AdapterErrorResolverInterface
{
    public function resolve(AdapterException $e): ?ChannelStatus;
}
