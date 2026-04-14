<?php

namespace App\Handlers\Message;

use App\Commands\Message\SendMessageCommand;
use App\Handlers\Message\Contracts\SendMessageHandlerInterface;
use App\Models\Message;

class SendMessageHandler implements SendMessageHandlerInterface
{
    /**
     * Handler for SendMessage action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        //
    ) {}

    /**
     * Execute the SendMessage action.
     */
    public function handle(SendMessageCommand $command): Message
    {

    }
}
