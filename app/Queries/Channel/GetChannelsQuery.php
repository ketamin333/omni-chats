<?php

namespace App\Queries\Channel;

use App\Http\Requests\Channel\IndexRequest;

readonly class GetChannelsQuery
{
    /**
     * Data Transfer Object for GetChannels read operation.
     *
     * Carries filter/pagination params from Request to Handler.
     */
    public function __construct(
        public int $companyId,
        public int $perPage = 25,
    ) {}

    /**
     * Create a GetChannelsQuery instance from a FormRequest.
     */
    public static function fromRequest(IndexRequest $request): self
    {
        return new self(
            companyId: $request->user()->company_id,
        );
    }
}
