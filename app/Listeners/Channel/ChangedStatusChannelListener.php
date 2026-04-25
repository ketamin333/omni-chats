<?php

namespace App\Listeners\Channel;

use App\Enums\ChannelStatus;
use App\Events\ChannelCreated;
use App\Events\ChannelUpdated;
use App\Jobs\InitializeChannelJob;
use App\Jobs\ReinitializeChannelJob;
use App\Jobs\StopChannelJob;
use Illuminate\Contracts\Bus\Dispatcher;

class ChangedStatusChannelListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private Dispatcher $bus,
    ) {}

    /**
     * Handle the event.
     */
    public function handle(ChannelUpdated|ChannelCreated $event): void
    {
        $job = match ($event->channel->status) {
            ChannelStatus::PENDING    => new InitializeChannelJob($event->channel),
            ChannelStatus::CONNECTING => new ReinitializeChannelJob($event->channel),
            ChannelStatus::PAUSED     => new StopChannelJob($event->channel),
            default => null,
        };

        if ($job) {
            $this->bus->dispatch($job);
        }
    }
}
