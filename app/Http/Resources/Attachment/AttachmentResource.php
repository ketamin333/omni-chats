<?php

namespace App\Http\Resources\Attachment;

use App\Http\Resources\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
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
            'attachment_id' => $this->attachment_id,
            'original_name' => $this->original_name,
            'url'           => $this->url,
            'mime_type'     => $this->mime_type,
            'size'          => $this->size,
            'timestamps'    => $this->getTimestamps()
        ];
    }
}
