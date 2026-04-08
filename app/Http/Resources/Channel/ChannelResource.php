<?php

namespace App\Http\Resources\Channel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'channel_id'   => $this->channel_id,
            'adapter'      => $this->adapter,
            'channel_name' => $this->channel_name,
            'status'       => $this->status,
            'settings'     => $this->settings,

            'timestamps'   => $this->getTimestamps(),
        ];
    }

    protected function getTimestamps(): array
    {
        return [
            'created_at' => $this->created_at->unix(),
        ];
    }
}
