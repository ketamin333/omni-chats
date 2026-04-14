<?php

namespace App\Services\Adapters\Telegram\Bot\DTO\Contracts;

interface TelegramBotFileInterface
{
    public function fileId(): string;
    public function fileSize(): int;
}
