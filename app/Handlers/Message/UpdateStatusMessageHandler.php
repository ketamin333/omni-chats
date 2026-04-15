<?php

namespace App\Handlers\Message;

use App\Commands\Message\UpdateStatusMessageCommand;
use App\Handlers\Message\Contracts\UpdateStatusMessageHandlerInterface;
use App\Models\Message;

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
        //
    }
}
