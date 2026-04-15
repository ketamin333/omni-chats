<?php

namespace App\Commands\Message;

use App\Enums\MessageDirection;
use App\Models\Conversation;

readonly class CreateMessageCommand
{
    /**
     * Data Transfer Object for CreateMessage write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public Conversation     $conversation,
        public MessageDirection $direction,
        public ?string          $externalId = null,
        public ?string          $text = null,
    ) {}
}
