<?php

namespace App\Commands\User;

use App\Http\Requests\User\UpdateAvatarRequest;
use App\Models\User;
use Illuminate\Http\UploadedFile;

readonly class UpdateAvatarUserCommand
{
    /**
     * Data Transfer Object for UpdateUserAvatar write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public User         $user,
        public UploadedFile $avatar,
    ) {}

    /**
     * Create a UpdateUserAvatarCommand instance from a FormRequest.
     */
    public static function fromRequest(UpdateAvatarRequest $request, User $user): self
    {
        return new self(
            user: $user,
            avatar: $request->file('avatar'),
        );
    }
}
