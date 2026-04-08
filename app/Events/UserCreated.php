<?php

namespace App\Events;

use App\Enums\BroadcastChannel;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;

class UserCreated implements ShouldDispatchAfterCommit, ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly User $user,
    ) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel(BroadcastChannel::USERS->value);
    }

    public function broadcastWith(): array
    {
        return (new UserResource($this->user))->resolve();
    }
}
