<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id'     => $this->user_id,
            'username'    => $this->username,
            'email'       => $this->email,
            'avatar_url'  => $this->avatar_url,
            'phone'       => $this->phone,

            'timestamps' => [
                'last_login_at' => $this->last_login_at?->unix(),
            ]
        ];
    }
}
