<?php

namespace App\Handlers\Channel;

use App\Commands\Channel\CreateChannelCommand;
use App\Events\ChannelCreated;
use App\Handlers\Channel\Contracts\CreateChannelHandlerInterface;
use App\Models\Channel;
use Illuminate\Contracts\Events\Dispatcher;
use Throwable;

class CreateChannelHandler implements CreateChannelHandlerInterface
{
    public function __construct(
        protected Dispatcher $dispatcher,
    ) {}

    /**
     * Execute the CreateChannel action.
     *
     * @param CreateChannelCommand $command
     * @return Channel
     * @throws Throwable
     */
    public function handle(CreateChannelCommand $command): Channel
    {
        $channel = Channel::create([
            'company_id'   => $command->companyId,
            'adapter_id'   => $command->adapterId,
            'channel_name' => $command->channelName,
            'credentials'  => $command->credentials,
            'settings'     => $command->settings,
        ]);

        $this->dispatcher->dispatch(new ChannelCreated($channel));

        return $channel;
    }
}
