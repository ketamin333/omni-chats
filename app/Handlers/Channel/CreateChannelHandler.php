<?php

namespace App\Handlers\Channel;

use App\Commands\Channel\CreateChannelCommand;
use App\Events\ChannelCreated;
use App\Handlers\Channel\Contracts\CreateChannelHandlerInterface;
use App\Models\Channel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CreateChannelHandler implements CreateChannelHandlerInterface
{
    /**
     * Execute the CreateChannel action.
     *
     * @param CreateChannelCommand $command
     * @return Channel
     * @throws Throwable
     */
    public function handle(CreateChannelCommand $command): Channel
    {
        $avatar = $command->avatar?->store('channels', 'public');

        try {
            return DB::transaction(function () use ($command, $avatar) {
                $channel = Channel::create([
                    'company_id'   => $command->companyId,
                    'channel_name' => $command->channelName,
                    'type'         => $command->type,
                    'credentials'  => $command->credentials,
                    'avatar'       => $avatar,
                ]);

                Event::dispatch(new ChannelCreated($channel));

                return $channel;
            });
        } catch (Throwable $e) {
            Storage::disk('public')->delete($avatar);

            throw $e;
        }
    }
}
