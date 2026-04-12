<?php

namespace App\Handlers\Channel;

use App\Commands\Channel\DeleteChannelCommand;
use App\Events\ChannelDeleted;
use App\Handlers\Channel\Contracts\DeleteChannelHandlerInterface;
use Illuminate\Contracts\Events\Dispatcher;

class DeleteChannelHandler implements DeleteChannelHandlerInterface
{
    /**
     * Handler for DeleteChannel action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected Dispatcher $dispatcher,
    ) {}

    /**
     * Execute the DeleteChannel action.
     */
    public function handle(DeleteChannelCommand $command): void
    {
        $command->channel->deleteOrFail();

        $this->dispatcher->dispatch(new ChannelDeleted($command->channel));
    }
}
