<?php

namespace App\Services\Adapters\Telegram\Bot\Handlers\Contracts;

use App\Models\Channel;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotMessage;

interface TelegramBotMessageHandlerInterface
{
    public function handle(Channel $channel, TelegramBotMessage $message): void;
}
