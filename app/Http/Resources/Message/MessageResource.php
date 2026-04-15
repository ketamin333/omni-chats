<?php

namespace App\Http\Resources\Message;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message_id' => $this->message_id,
            'direction'  => $this->direction,
            'text'       => $this->text,

            'timestamps' => $this->getTimestamps()
        ];
    }

    protected function getTimestamps(): array
    {
        return [
            'created_at' => $this->created_at->unix(),
            'updated_at' => $this->updated_at->unix(),
        ];
    }
}
