<?php

namespace App\Services\Adapters\Telegram\Bot\Client\Factories;

use App\Services\Adapters\Telegram\Bot\Client\Contracts\TelegramBotClientInterface;
use App\Services\Adapters\Telegram\Bot\Client\TelegramBotClient;

class TelegramBotClientFactory
{
    public function make(string $botToken): TelegramBotClientInterface
    {
        return new TelegramBotClient($botToken);
    }
}
