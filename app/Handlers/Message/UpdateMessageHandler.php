<?php

namespace App\Handlers\Message;

use App\Commands\Message\UpdateMessageCommand;
use App\Handlers\Message\Contracts\UpdateMessageHandlerInterface;
use App\Models\Message;

class UpdateMessageHandler implements UpdateMessageHandlerInterface
{
    /**
     * Handler for UpdateMessage action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        //
    ) {}

    /**
     * Execute the UpdateMessage action.
     */
    public function handle(UpdateMessageCommand $command): Message
    {
        $data = array_filter(['text' => $command->text, 'external_id' => $command->externalId], fn ($i) => $i !== null);

        $command->message->update($data);

        return $command->message->refresh();
    }
}
