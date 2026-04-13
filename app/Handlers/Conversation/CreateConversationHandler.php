<?php

namespace App\Handlers\Conversation;

use App\Commands\Conversation\CreateConversationCommand;
use App\Events\ConversationCreated;
use App\Handlers\Conversation\Contracts\CreateConversationHandlerInterface;
use App\Models\Conversation;
use Illuminate\Contracts\Events\Dispatcher;

class CreateConversationHandler implements CreateConversationHandlerInterface
{
    /**
     * Handler for CreateConversation action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected Dispatcher $dispatcher,
    ) {}

    /**
     * Execute the CreateConversation action.
     */
    public function handle(CreateConversationCommand $command): Conversation
    {
        $conversation = Conversation::create([
            'contact_id'  => $command->contactId,
            'channel_id'  => $command->channelId,
            'external_id' => $command->externalId,
        ]);

        $this->dispatcher->dispatch(new ConversationCreated($conversation));

        return $conversation;
    }
}
