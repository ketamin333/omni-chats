<?php

namespace App\Http\Controllers;

use App\Commands\Channel\CreateChannelCommand;
use App\Commands\Channel\DeleteChannelCommand;
use App\Commands\Channel\UpdateStatusChannelCommand;
use App\Handlers\Channel\Contracts\CreateChannelHandlerInterface;
use App\Handlers\Channel\Contracts\DeleteChannelHandlerInterface;
use App\Handlers\Channel\Contracts\GetChannelHandlerInterface;
use App\Handlers\Channel\Contracts\GetChannelsHandlerInterface;
use App\Handlers\Channel\Contracts\UpdateStatusChannelHandlerInterface;
use App\Http\Requests\Channel\IndexRequest;
use App\Http\Requests\Channel\StoreRequest;
use App\Http\Requests\Channel\UpdateStatusRequest;
use App\Http\Resources\Channel\ChannelResource;
use App\Models\Channel;
use App\Queries\Channel\GetChannelQuery;
use App\Queries\Channel\GetChannelsQuery;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChannelController extends Controller
{
    public function __construct(
        private readonly GetChannelsHandlerInterface $getChannelsHandler,
        private readonly GetChannelHandlerInterface $getChannelHandler,
        private readonly CreateChannelHandlerInterface $createChannelHandler,
        private readonly UpdateStatusChannelHandlerInterface $updateStatusChannelHandler,
        private readonly DeleteChannelHandlerInterface $deleteChannelHandler,
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

    public function updateStatus(UpdateStatusRequest $request, string $channelId): JsonResponse
    {
        $channel = $this->getChannelHandler->handle(
            new GetChannelQuery($request->user()->company_id, $channelId)
        );

        $this->authorize('update', $channel);

        $channel = $this->updateStatusChannelHandler->handle(
            UpdateStatusChannelCommand::fromRequest($request, $channel)
        );

        return ApiResponse::success(
            new ChannelResource($channel),
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $channelId): Response
    {
        $channel = $this->getChannelHandler->handle(
            new GetChannelQuery($request->user()->company_id, $channelId)
        );

        $this->authorize('delete', $channel);

        $this->deleteChannelHandler->handle(
            new DeleteChannelCommand($channel)
        );

        return ApiResponse::noContent();
    }
}
