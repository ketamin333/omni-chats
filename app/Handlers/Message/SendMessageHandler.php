<?php

namespace App\Handlers\Message;

use App\Commands\Message\CreateMessageCommand;
use App\Commands\Message\SendMessageCommand;
use App\Enums\MessageDirection;
use App\Events\OutgoingMessageCreated;
use App\Handlers\Message\Contracts\CreateMessageHandlerInterface;
use App\Handlers\Message\Contracts\SendMessageHandlerInterface;
use App\Models\Message;
use Illuminate\Contracts\Events\Dispatcher;

class SendMessageHandler implements SendMessageHandlerInterface
{
    /**
     * Handler for SendMessage action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected CreateMessageHandlerInterface $createMessageHandler,
        protected Dispatcher $dispatcher,
    ) {}

    /**
     * Execute the SendMessage action.
     */
    public function handle(SendMessageCommand $command): Message
    {
        $message = $this->createMessageHandler->handle(
            new CreateMessageCommand(
                conversation: $command->conversation,
                direction: MessageDirection::OUTGOING,
                text: $command->text,
            )
        );

        $this->dispatcher->dispatch(new OutgoingMessageCreated($command->conversation->channel, $message));

        return $message;
    }
}
