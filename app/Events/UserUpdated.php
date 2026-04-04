<?php

namespace App\Events;

use App\Enums\BroadcastChannel;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserUpdated implements ShouldDispatchAfterCommit, ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly User $user
    ) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel(BroadcastChannel::USER->value);
    }

    public function broadcastWith(): array
    {
        return (new UserResource($this->user))->resolve();
    }
}
