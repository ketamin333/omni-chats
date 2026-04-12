<?php

namespace App\Queries\Channel;

readonly class GetChannelQuery
{
    /**
     * Data Transfer Object for GetChannel read operation.
     *
     * Carries filter/pagination params from Request to Handler.
     */
    public function __construct(
        public int $companyId,
        public int $channelId,
    ) {}
}
