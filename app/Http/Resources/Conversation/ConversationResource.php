<?php

namespace App\Http\Resources\Conversation;

use App\Http\Resources\Channel\ChannelResource;
use App\Http\Resources\Concerns\HasTimestamps;
use App\Http\Resources\Contact\ContactResource;
use App\Http\Resources\Message\MessageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    use HasTimestamps;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'conversation_id' => $this->conversation_id,
            'status'          => $this->status,
            'contact'         => new ContactResource($this->whenLoaded('contact')),
            'channel'         => new ChannelResource($this->whenLoaded('channel')),
            'last_message'    => new MessageResource($this->whenLoaded('lastMessage')),

            'timestamps'      => $this->getTimestamps()
        ];
    }
}
