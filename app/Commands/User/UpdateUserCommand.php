<?php

namespace App\Commands\User;

use App\Enums\Role;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\UploadedFile;

readonly class UpdateUserCommand
{
    /**
     * Data transfer object for UpdateUser handler.
     */
    public function __construct(
        public User $user,
        public ?string $username,
        public ?string $password,
        public ?UploadedFile $avatar,
        public ?string $phone,
        public ?Role $role,
    ) {}

    public static function fromRequest(UpdateRequest $request, User $user): UpdateUserCommand
    {
        return new self(
            user: $user,
            username: $request->username,
            password: $request->password,
            avatar: $request->file('avatar'),
            phone: $request->phone,
            role: $request->role ? Role::from($request->role) : null,
        );
    }
}
