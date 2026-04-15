<?php

namespace App\Http\Resources\Contact;

use App\Http\Resources\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'contact_id' => $this->contact_id,
            'username'   => $this->username,
            'phone'      => $this->phone,
            'email'      => $this->email,

            'timestamps' => $this->getTimestamps(),
        ];
    }
}
