<?php

namespace App\Commands\User;

use App\Enums\Role;
use App\Http\Requests\User\StoreRequest;
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
        public Role $role = Role::USER,
    ) {}

    public static function fromRequest(StoreRequest $request): self
    {
        return new self(
            companyId: $request->user()->company_id,
            username: $request->username,
            password: $request->password,
            email: $request->email,
            avatar: $request->file('avatar'),
            phone: $request->phone ?? null,
            role: Role::from($request->role),
        );
    }
}
