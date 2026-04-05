<?php

namespace App\Commands\User;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Models\User;

readonly class ChangePasswordUserCommand
{
    /**
     * Data Transfer Object for ChangePasswordUser write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public User $user,
        public string $password,
    ) {}

    /**
     * Create a ChangePasswordUserCommand instance from a FormRequest.
     */
    public static function fromRequest(ChangePasswordRequest $request, User $user): self
    {
        return new self(
            user: $user,
            password: $request->password,
        );
    }
}
