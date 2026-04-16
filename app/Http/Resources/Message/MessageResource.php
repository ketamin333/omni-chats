<?php

namespace App\Http\Resources\Message;

use App\Http\Resources\Attachment\AttachmentResource;
use App\Http\Resources\Concerns\HasTimestamps;
use App\Http\Resources\User\UserListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'message_id'  => $this->message_id,
            'sender'      => new UserListResource($this->whenLoaded('sender')),
            'direction'   => $this->direction,
            'status'      => $this->status,
            'text'        => $this->text,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),

            'timestamps'  => $this->getTimestamps()
        ];
    }
}
