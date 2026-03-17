<?php

namespace App\Commands\Auth;

use App\Http\Requests\Auth\LoginRequest;

readonly class LoginCommand
{
    /**
     * Data transfer object for Login handler.
     */
    public function __construct(
        public string     $email,
        public string     $password,
        public bool|null  $remember = false,
    ) {}

    public static function fromRequest(LoginRequest $request): static
    {
        return new static(
            email: $request->email,
            password: $request->password,
            remember: $request->remember ?? false,
        );
    }
}
