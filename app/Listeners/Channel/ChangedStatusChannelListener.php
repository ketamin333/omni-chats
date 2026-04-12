<?php

namespace App\Listeners\Channel;

use App\Enums\ChannelStatus;
use App\Events\ChannelCreated;
use App\Events\ChannelUpdated;
use App\Jobs\InitializeChannelJob;
use App\Jobs\ReinitializeChannelJob;
use App\Jobs\StopChannelJob;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        match ($event->channel->status) {
            ChannelStatus::PENDING    => $this->bus->dispatch(new InitializeChannelJob($event->channel)),
            ChannelStatus::CONNECTING => $this->bus->dispatch(new ReinitializeChannelJob($event->channel)),
            ChannelStatus::PAUSED     => $this->bus->dispatch(new StopChannelJob($event->channel)),
            default => null,
        };
    }
}
