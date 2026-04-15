<?php

namespace App\Console\Commands;

use App\Commands\Message\SendMessageCommand;
use App\Handlers\Message\Contracts\SendMessageHandlerInterface;
use App\Models\Conversation;
use Illuminate\Console\Command;

class TestKetamineCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ketamine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command for ketamine';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $conversation = Conversation::with('channel.adapter')->first();

        $handler = app(SendMessageHandlerInterface::class);
        $handler->handle(new SendMessageCommand(
            conversation: $conversation,
            text: 'test message',
        ));

        $this->info('Done');
    }
}
