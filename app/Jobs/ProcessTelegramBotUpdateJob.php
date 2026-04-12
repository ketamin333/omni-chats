<?php

namespace App\Jobs;

use App\Models\Channel;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessTelegramBotUpdateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Channel $channel,
        private readonly TelegramBotUpdate $update
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

    }
}
