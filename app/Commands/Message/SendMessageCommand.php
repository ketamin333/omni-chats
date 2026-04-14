<?php

namespace App\Commands\Message;

use App\Models\Conversation;

readonly class SendMessageCommand
{
    /**
     * Data Transfer Object for SendMessage write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        protected Conversation $conversation,
        protected ?string      $text = null
    ) {}

    /**
     * Create a SendMessageCommand instance from a FormRequest.
     */
//    public static function fromRequest(): self
//    {
//        return new self();
//    }
}
