<?php

namespace App\Http\Controllers;

use App\Handlers\Conversation\Contracts\GetConversationHandlerInterface;
use App\Handlers\Message\Contracts\GetMessagesHandlerInterface;
use App\Http\Requests\Message\IndexRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use App\Queries\Conversation\GetConversationQuery;
use App\Queries\Message\GetMessagesQuery;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(
        private readonly GetConversationHandlerInterface $getConversationHandler,
        private readonly GetMessagesHandlerInterface     $getMessagesHandler,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request, string $conversationId): JsonResponse
    {
        $conversation = $this->getConversationHandler->handle(
            new GetConversationQuery($request->user()->company_id, $conversationId),
        );

        $messages = $this->getMessagesHandler->handle(
            GetMessagesQuery::fromRequest($request, $conversation),
        );

        return ApiResponse::cursor($messages, MessageResource::class);
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
    public function show(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
