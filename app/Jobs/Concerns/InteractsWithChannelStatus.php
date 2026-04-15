<?php

namespace App\Jobs\Concerns;

use App\Commands\Channel\UpdateStatusChannelCommand;
use App\Enums\ChannelStatus;
use App\Exceptions\Adapters\AdapterAuthException;
use App\Exceptions\Adapters\AdapterException;
use App\Exceptions\Adapters\AdapterRateLimitException;
use App\Handlers\Channel\Contracts\UpdateStatusChannelHandlerInterface;
use Throwable;

trait InteractsWithChannelStatus
{
    public function failed(Throwable $e): void
    {
        if (!$e instanceof AdapterException) {
            return;
        }

        app(UpdateStatusChannelHandlerInterface::class)->handle(
            new UpdateStatusChannelCommand($this->channel, $this->resolveStatus($e))
        );
    }

    private function resolveStatus(AdapterException $e): ChannelStatus
    {
        return match (true) {
            $e instanceof AdapterAuthException       => ChannelStatus::INVALID_CREDENTIALS,
            $e instanceof AdapterRateLimitException  => ChannelStatus::RATE_LIMITED,
            default                                  => ChannelStatus::DISCONNECTED
        };
    }
}
