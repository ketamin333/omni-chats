<?php

namespace App\Jobs;

use App\Models\Channel;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotUpdate;
use App\Services\Adapters\Telegram\Bot\TelegramBotUpdateService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessTelegramBotUpdateJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Channel           $channel,
        private readonly TelegramBotUpdate $update
    ) {}

    /**
     * Execute the job.
     */
    public function handle(TelegramBotUpdateService $service): void
    {
        $service->process($this->channel, $this->update);
    }
}
