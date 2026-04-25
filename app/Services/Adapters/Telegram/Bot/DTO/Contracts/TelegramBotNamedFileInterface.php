<?php

namespace App\Services\Adapters\Telegram\Bot\DTO\Contracts;

interface TelegramBotNamedFileInterface
{
    public function fileName(): string;
}
