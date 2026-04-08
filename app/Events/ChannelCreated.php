<?php

namespace App\Events;

use App\Enums\BroadcastChannel;
use App\Http\Resources\Channel\ChannelResource;
use App\Models\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChannelCreated implements ShouldDispatchAfterCommit, ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly Channel $channel,
    ) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel(BroadcastChannel::CHANNELS->value);
    }

    public function broadcastWith(): array
    {
        return (new ChannelResource($this->channel))->resolve();
    }
}
