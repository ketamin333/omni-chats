<?php

namespace App\Queries\Conversation;

use App\Http\Requests\Conversation\IndexRequest;

readonly class GetConversationsQuery
{
    /**
     * Data Transfer Object for GetConversations read operation.
     *
     * Carries filter/pagination params from Request to Handler.
     */
    public function __construct(
        public int $companyId,
        public int $perPage = 25,
    ) {}

    /**
     * Create a GetConversationsQuery instance from a FormRequest.
     */
    public static function fromRequest(IndexRequest $request): self
    {
        return new self(
            companyId: $request->user()->company_id,
        );
    }
}
