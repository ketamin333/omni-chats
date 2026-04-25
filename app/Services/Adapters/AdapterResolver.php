<?php

namespace App\Services\Adapters;

use App\Models\Adapter;
use App\Services\Adapters\Contracts\AdapterHandlerInterface;
use Illuminate\Contracts\Container\Container;
use RuntimeException;

class AdapterResolver
{
    public function __construct(
        private Container $container,
    ) {}

    public function resolve(Adapter $adapter): AdapterHandlerInterface
    {
        $handler =  $this->container->make($adapter->handler);

        if (!$handler instanceof AdapterHandlerInterface) {
            throw new RuntimeException("Handler {$adapter->handler} must implement AdapterHandlerInterface");
        }

        return $handler;
    }
}
