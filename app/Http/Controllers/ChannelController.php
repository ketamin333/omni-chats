<?php

namespace App\Http\Controllers;

use App\Commands\Channel\CreateChannelCommand;
use App\Handlers\Channel\Contracts\CreateChannelHandlerInterface;
use App\Handlers\Channel\Contracts\GetChannelsHandlerInterface;
use App\Http\Requests\Channel\IndexRequest;
use App\Http\Requests\Channel\StoreRequest;
use App\Http\Resources\Channel\ChannelResource;
use App\Models\Channel;
use App\Queries\Channel\GetChannelsQuery;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function __construct(
        private readonly GetChannelsHandlerInterface $getChannelsHandler,
        private readonly CreateChannelHandlerInterface $createChannelHandler,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $this->authorize('viewAny', Channel::class);

        $channels = $this->getChannelsHandler->handle(
            GetChannelsQuery::fromRequest($request)
        );

        return ApiResponse::paginated($channels, ChannelResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $this->authorize('create', Channel::class);

        $channel = $this->createChannelHandler->handle(
            CreateChannelCommand::fromRequest($request),
        );

        return ApiResponse::success(
            new ChannelResource($channel),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
