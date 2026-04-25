<?php

namespace App\Commands\Contact;

readonly class CreateContactCommand
{
    /**
     * Data Transfer Object for CreateContact write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public int     $companyId,
        public ?string $username = null,
        public ?string $avatar   = null,
        public ?string $phone    = null,
        public ?string $email    = null
    ) {}

    /**
     * Create a CreateContactCommand instance from a FormRequest.
     */
//    public static function fromRequest(): self
//    {
//        return new self();
//    }
}
