<?php

namespace App\Queries\Permission;

readonly class GetPermissionsQuery
{
    /**
     * Data Transfer Object for GetPermission read operation.
     *
     * Carries filter/pagination params from Request to Handler.
     */
    public function __construct(
        //
    ) {}

    /**
     * Create a GetPermissionQuery instance from a FormRequest.
     */
    public static function fromRequest(): self
    {
        return new self();
    }
}
