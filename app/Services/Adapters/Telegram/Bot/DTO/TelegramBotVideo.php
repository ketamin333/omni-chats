<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use App\Services\Adapters\Telegram\Bot\DTO\Contracts\TelegramBotFileInterface;
use App\Services\Adapters\Telegram\Bot\DTO\Contracts\TelegramBotNamedFileInterface;

class TelegramBotVideo implements TelegramBotFileInterface, TelegramBotNamedFileInterface
{
    public function __construct(
        protected array $video
    ) {}

    public function duration(): int
    {
        return (int) $this->video['duration'];
    }

    public function width(): int
    {
        return (int) $this->video['width'];
    }

    public function height(): int
    {
        return (int) $this->video['height'];
    }

    public function fileName(): string
    {
        return (string) $this->video['file_name'];
    }

    public function mimeType(): string
    {
        return (string) $this->video['mime_type'];
    }

    public function fileId(): string
    {
        return (string) $this->video['file_id'];
    }

    public function fileUniqueId(): string
    {
        return (string) $this->video['file_unique_id'];
    }

    public function fileSize(): int
    {
        return (int) $this->video['file_size'];
    }
}
