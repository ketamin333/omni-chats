<?php

namespace App\Handlers\Message;

use App\Commands\Message\UpdateStatusMessageCommand;
use App\Handlers\Message\Contracts\UpdateStatusMessageHandlerInterface;
use App\Models\Message;
use InvalidArgumentException;

class UpdateStatusMessageHandler implements UpdateStatusMessageHandlerInterface
{
    /**
     * Handler for UpdateStatusMessage action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        //
    ) {}

    /**
     * Execute the UpdateStatusMessage action.
     */
    public function handle(UpdateStatusMessageCommand $command): Message
    {
        if ($command->message->status === $command->status) {
            return $command->message;
        }

        if (!in_array($command->status, $command->message->status->allowedTransitions())) {
            throw new InvalidArgumentException(
                "Cannot transition from {$command->message->status->value} to {$command->status->value}"
            );
        }

        $command->message->update(['status' => $command->status]);

        return $command->message->fresh();
    }
}
