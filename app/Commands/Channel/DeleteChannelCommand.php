<?php

namespace App\Commands\Channel;

use App\Models\Channel;

readonly class DeleteChannelCommand
{
    /**
     * Data Transfer Object for DeleteChannel write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public Channel $channel
    ) {}
}
