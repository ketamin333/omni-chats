<?php

namespace App\Commands\Channel;

use App\Models\Channel;

readonly class UpdateCredentialsChannelCommand
{
    /**
     * Data Transfer Object for UpdateCredentialsChannel write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public Channel $channel,
        public array $credentials
    ) {}
}
