<?php

namespace App\Queries\Message;

use App\Http\Requests\Message\IndexRequest;
use App\Models\Conversation;

readonly class GetMessagesQuery
{
    /**
     * Data Transfer Object for GetMessagesQuery read operation.
     *
     * Carries filter/pagination params from Request to Handler.
     */
    public function __construct(
        public Conversation $conversation,
        public int          $perPage = 25,
        public ?string      $cursor = null,
    ) {}

    /**
     * Create a GetMessagesQueryQuery instance from a FormRequest.
     */
    public static function fromRequest(IndexRequest $request, Conversation $conversation): self
    {
        return new self(
            conversation: $conversation,
            cursor: $request->cursor ?? null,
        );
    }
}
