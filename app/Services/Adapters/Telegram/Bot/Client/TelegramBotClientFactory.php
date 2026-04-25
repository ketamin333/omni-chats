<?php

namespace App\Services\Adapters\Telegram\Bot\Client;

class TelegramBotClientFactory
{
    public function make(string $botToken): TelegramBotClientInterface
    {
        return new TelegramBotClient($botToken);
    }
}
