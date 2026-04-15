<?php

namespace App\Listeners\Message;

use App\Events\OutgoingMessageCreated;
use App\Jobs\DeliverOutgoingMessageJob;
use Illuminate\Contracts\Bus\Dispatcher;

class DeliverOutgoingMessageListener
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
    public function handle(OutgoingMessageCreated $event): void
    {
        $this->bus->dispatch(new DeliverOutgoingMessageJob($event->channel, $event->message));
    }
}
