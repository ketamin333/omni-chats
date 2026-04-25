<?php

namespace App\Http\Controllers;

use App\Handlers\Conversation\Contracts\GetConversationHandlerInterface;
use App\Handlers\Conversation\Contracts\GetConversationsHandlerInterface;
use App\Http\Requests\Conversation\IndexRequest;
use App\Http\Resources\Conversation\ConversationResource;
use App\Models\Conversation;
use App\Queries\Conversation\GetConversationQuery;
use App\Queries\Conversation\GetConversationsQuery;
use App\Repositories\ConversationRepository;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __construct(
        private readonly GetConversationsHandlerInterface $getConversationsHandler,
        private readonly GetConversationHandlerInterface  $getConversationHandler
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $conversations = $this->getConversationsHandler->handle(
            GetConversationsQuery::fromRequest($request)
        );

        return ApiResponse::paginated($conversations, ConversationResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $conversationId): JsonResponse
    {
        $conversation = $this->getConversationHandler->handle(
            new GetConversationQuery($request->user()->company_id, $conversationId)
        );

        return ApiResponse::success(new ConversationResource($conversation));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
