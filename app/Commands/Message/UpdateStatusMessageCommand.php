<?php

namespace App\Commands\Message;

use App\Enums\MessageStatus;
use App\Models\Message;

readonly class UpdateStatusMessageCommand
{
    /**
     * Data Transfer Object for UpdateStatusMessage write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public Message       $message,
        public MessageStatus $status,
    ) {}
}
