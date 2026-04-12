<?php

namespace App\Commands\Channel;

use App\Enums\ChannelStatus;
use App\Http\Requests\Channel\UpdateStatusRequest;
use App\Models\Channel;

readonly class UpdateStatusChannelCommand
{
    /**
     * Data Transfer Object for UpdateStatusChannel write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public Channel $channel,
        public ChannelStatus $status
    ) {}

    public static function fromRequest(UpdateStatusRequest $request, Channel $channel): self
    {
        return new self(
            channel: $channel,
            status: ChannelStatus::from($request->status),
        );
    }
}
