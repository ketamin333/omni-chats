<?php

namespace App\Events;

use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly Message $message
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("conversations.{$this->message->conversation_id}"),
            new PrivateChannel("chats.{$this->message->conversation->channel->company_id}")
        ];
    }

    public function broadcastWith(): array
    {
        return (new MessageResource($this->message))->resolve();
    }
}
