<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'company_id'  => $this->company_id,
            'username'    => $this->username,
            'email'       => $this->email,
            'avatar_url'  => $this->avatar_url,
            'phone'       => $this->phone,
            'permissions' => $this->permissions->pluck('slug'),
            'timestamps'  => $this->getTimestamps()
        ];
    }

    protected function getTimestamps(): array
    {
        return [
            'last_login_at' => $this->last_login_at?->unix(),
            'created_at'    => $this->created_at->unix(),
            'updated_at'    => $this->updated_at->unix(),
            'deleted_at'    => $this->deleted_at?->unix(),
        ];
    }
}
