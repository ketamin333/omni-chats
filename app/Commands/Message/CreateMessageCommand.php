<?php

namespace App\Commands\Message;

use App\Enums\MessageDirection;

readonly class CreateMessageCommand
{
    /**
     * Data Transfer Object for CreateMessage write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public string $conversationId,
        public string $externalId,
        public MessageDirection $direction,
        public ?string $text = null,
    ) {}
}
