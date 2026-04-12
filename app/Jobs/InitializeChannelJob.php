<?php

namespace App\Jobs;

use App\Models\Channel;
use App\Services\Adapters\AdapterResolver;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class InitializeChannelJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Channel $channel,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(AdapterResolver $resolver): void
    {
        $handler = $resolver->resolve($this->channel->adapter);
        $handler->initialize($this->channel);
    }
}
