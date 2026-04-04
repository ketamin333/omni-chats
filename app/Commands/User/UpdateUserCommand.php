<?php

namespace App\Commands\User;

use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\UploadedFile;

readonly class UpdateUserCommand
{
    /**
     * Data transfer object for UpdateUser handler.
     */
    public function __construct(
        public User    $user,
        public ?string $username,
        public ?string $phone,
        public ?array  $permissions,
    ) {}

    public static function fromRequest(UserUpdateRequest $request, User $user): UpdateUserCommand
    {
        return new self(
            user: $user,
            username: $request->username,
            phone: $request->phone,
            permissions: $request->permissions,
        );
    }
}
