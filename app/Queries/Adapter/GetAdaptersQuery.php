<?php

namespace App\Queries\Adapter;

readonly class GetAdaptersQuery
{
    /**
     * Data Transfer Object for GetAdapters read operation.
     *
     * Carries filter/pagination params from Request to Handler.
     */
    public function __construct(
        //
    ) {}

    /**
     * Create a GetAdaptersQuery instance from a FormRequest.
     */
    public static function fromRequest(): self
    {
        return new self();
    }
}
