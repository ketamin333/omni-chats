<?php

namespace App\Commands\User;

use App\Http\Requests\User\UserStoreRequest;
use Illuminate\Http\UploadedFile;

readonly class CreateUserCommand
{
    public function __construct(
        public int    $companyId,
        public string $username,
        public string $password,
        public string $email,
        public ?UploadedFile $avatar,
        public ?string $phone = null,
        public array   $permissions = [],
    ) {}

    public static function fromRequest(UserStoreRequest $request): self
    {
        return new self(
            companyId: $request->user()->company_id,
            username: $request->username,
            password: $request->password,
            email: $request->email,
            avatar: $request->file('avatar'),
            phone: $request->phone ?? null,
            permissions: $request->permissions ?? [],
        );
    }
}
