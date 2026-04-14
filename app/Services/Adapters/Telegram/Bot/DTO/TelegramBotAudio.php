<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use App\Services\Adapters\Telegram\Bot\DTO\Contracts\TelegramBotFileInterface;
use App\Services\Adapters\Telegram\Bot\DTO\Contracts\TelegramBotNamedFileInterface;

class TelegramBotAudio implements TelegramBotFileInterface, TelegramBotNamedFileInterface
{
    public function __construct(
        protected array $audio,
    ) {}

    public function duration(): int
    {
        return (int) $this->audio['duration'];
    }

    public function fileName(): string
    {
        return (string) $this->audio['file_name'];
    }

    public function mimeType(): string
    {
        return (string) $this->audio['mime_type'];
    }

    public function fileId(): string
    {
        return (string) $this->audio['file_id'];
    }

    public function fileUniqueId(): string
    {
        return (string) $this->audio['file_unique_id'];
    }

    public function fileSize(): int
    {
        return (int) $this->audio['file_size'];
    }
}
