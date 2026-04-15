<?php

namespace App\Handlers\Message;

use App\Commands\Message\CreateMessageCommand;
use App\Events\MessageCreated;
use App\Handlers\Message\Contracts\CreateMessageHandlerInterface;
use App\Models\Message;
use Illuminate\Contracts\Events\Dispatcher;

class CreateMessageHandler implements CreateMessageHandlerInterface
{
    public function __construct(
        protected Dispatcher $dispatcher,
    ) {}

    /**
     * Execute the CreateMessage action.
     */
    public function handle(CreateMessageCommand $command): Message
    {
        $message = Message::create([
            'conversation_id' => $command->conversation->conversation_id,
            'direction'       => $command->direction,
            'external_id'     => $command->externalId,
            'text'            => $command->text,
        ]);

        $this->dispatcher->dispatch(new MessageCreated($message));

        return $message;
    }
}
