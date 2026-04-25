<?php

namespace App\Jobs;

use App\Jobs\Concerns\InteractsWithChannelStatus;
use App\Models\Channel;
use App\Models\Message;
use App\Services\Adapters\AdapterResolver;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeliverOutgoingMessageJob implements ShouldQueue
{
    use Queueable, InteractsWithChannelStatus;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Channel $channel,
        private readonly Message $message,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(AdapterResolver $resolver): void
    {
        $resolver->resolve($this->channel->adapter)->sendMessage($this->channel, $this->message);
    }
}
