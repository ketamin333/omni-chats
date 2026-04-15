<?php

namespace App\Listeners\Message;

use App\Events\MessageCreated;
use App\Events\OutgoingMessageCreated;
use App\Services\Adapters\AdapterResolver;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeliverOutgoingMessageListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly AdapterResolver $resolver,
    ) {}

    /**
     * Handle the event.
     */
    public function handle(OutgoingMessageCreated $event): void
    {
        $conversation = $event->conversation;
        $conversation->loadMissing('channel.adapter');
        $channel = $conversation->channel;

        $handle = $this->resolver->resolve($channel->adapter);
        $handle->sendMessage($channel, $event->message);
    }
}
