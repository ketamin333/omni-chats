<?php

namespace App\Queries\Conversation;

readonly class GetConversationQuery
{
    /**
     * Data Transfer Object for GetConversation read operation.
     *
     * Carries filter/pagination params from Request to Handler.
     */
    public function __construct(
        public int $companyId,
        public int $conversationId,
    ) {}
}
