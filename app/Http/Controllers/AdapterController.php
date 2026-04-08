<?php

namespace App\Http\Controllers;

use App\Enums\PermissionSlug;
use App\Handlers\Adapter\Contracts\GetAdaptersHandlerInterface;
use App\Http\Resources\Adapter\AdapterResource;
use App\Queries\Adapter\GetAdaptersQuery;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class AdapterController extends Controller
{
    public function __construct(
        private readonly GetAdaptersHandlerInterface $getAdaptersHandler,
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize(PermissionSlug::CHANNELS_MANAGE);

        $adapters = $this->getAdaptersHandler->handle(
            new GetAdaptersQuery()
        );

        return ApiResponse::success(
            AdapterResource::collection($adapters)
        );
    }
}
