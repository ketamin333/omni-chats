<?php

namespace App\Handlers\Channel;

use App\Commands\Channel\UpdateStatusChannelCommand;
use App\Events\ChannelUpdated;
use App\Handlers\Channel\Contracts\UpdateStatusChannelHandlerInterface;
use App\Models\Channel;
use Illuminate\Contracts\Events\Dispatcher;
use InvalidArgumentException;

class UpdateStatusChannelHandler implements UpdateStatusChannelHandlerInterface
{
    /**
     * Handler for UpdateStatusChannel action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        protected Dispatcher $dispatcher,
    ) {}

    /**
     * Execute the UpdateStatusChannel action.
     */
    public function handle(UpdateStatusChannelCommand $command): Channel
    {
        if ($command->channel->status === $command->status) {
            return $command->channel;
        }

        if (!in_array($command->status, $command->channel->status->allowedTransitions())) {
            throw new InvalidArgumentException(
                "Cannot transition from {$command->channel->status->value} to {$command->status->value}"
            );
        }

        $command->channel->update(['status' => $command->status]);
        $this->dispatcher->dispatch(new ChannelUpdated($command->channel));

        return $command->channel->refresh();
    }
}
