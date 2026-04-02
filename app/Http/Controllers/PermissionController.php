<?php

namespace App\Http\Controllers;

use App\Enums\PermissionSlug;
use App\Handlers\Permission\Contracts\GetPermissionsHandlerInterface;
use App\Http\Resources\Permission\PermissionResource;
use App\Queries\Permission\GetPermissionsQuery;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    public function __construct(
        private readonly GetPermissionsHandlerInterface $getPermissionHandler,
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize(PermissionSlug::USERS_MANAGE);

        $permissions = $this->getPermissionHandler->handle(
            new GetPermissionsQuery(),
        );

        return ApiResponse::success(
            PermissionResource::collection($permissions),
        );
    }
}
