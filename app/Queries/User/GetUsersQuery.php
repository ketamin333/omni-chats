<?php

namespace App\Queries\User;

use App\Http\Requests\User\IndexRequest;

readonly class GetUsersQuery
{
    /**
     * Data transfer object for GetUsers handler.
     */
    public function __construct(
        public int $companyId,
        public int $perPage = 25,
        public ?string $sortField = null,
        public ?string $sortOrder = null,
        public ?string $search = null,
    ) {}

    public static function fromRequest(IndexRequest $request): self
    {
        return new self(
            companyId: $request->user()->company_id,
            sortField: $request->sort_field ?: null,
            sortOrder: $request->sort_order ?? 'asc',
            search:    $request->search ?: null,
        );
    }
}
