<?php

namespace App\Handlers\Channel;

use App\Commands\Channel\UpdateCredentialsChannelCommand;
use App\Handlers\Channel\Contracts\UpdateCredentialsChannelHandlerInterface;
use App\Models\Channel;

class UpdateCredentialsChannelHandler implements UpdateCredentialsChannelHandlerInterface
{
    /**
     * Handler for UpdateCredentialsChannel action.
     *
     * Inject dependencies via constructor (repositories, services, etc.)
     */
    public function __construct(
        //
    ) {}

    /**
     * Execute the UpdateCredentialsChannel action.
     */
    public function handle(UpdateCredentialsChannelCommand $command): Channel
    {
        $command->channel->update(
            ['credentials' => array_merge($command->channel->credentials, $command->credentials)],
        );

        return $command->channel->fresh();
    }
}
