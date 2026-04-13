<?php

namespace App\Commands\Conversation;

readonly class CreateConversationCommand
{
    /**
     * Data Transfer Object for CreateConversation write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public int $contactId,
        public int $channelId,
        public int|string $externalId,
    ) {}

    /**
     * Create a CreateConversationCommand instance from a FormRequest.
     */
//    public static function fromRequest(): self
//    {
//        return new self();
//    }
}
