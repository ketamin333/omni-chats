<?php

namespace App\Commands\Message;

use App\Http\Requests\Message\StoreRequest;
use App\Models\Conversation;
use App\Models\User;

readonly class SendMessageCommand
{
    /**
     * Data Transfer Object for SendMessage write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public Conversation $conversation,
        public User         $sender,
        public ?string      $text = null
    ) {}

    /**
     * Create a SendMessageCommand instance from a FormRequest.
     */
    public static function fromRequest(StoreRequest $request, Conversation $conversation, User $sender): self
    {
        return new self(
            conversation: $conversation,
            sender: $sender,
            text: $request->text,
        );
    }
}
