<?php

namespace App\Commands\Message;

use App\Models\Message;

readonly class UpdateMessageCommand
{
    /**
     * Data Transfer Object for UpdateMessage write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public Message         $message,
        public int|string|null $externalId  = null,
        public ?string         $text = null
    ) {}
}
