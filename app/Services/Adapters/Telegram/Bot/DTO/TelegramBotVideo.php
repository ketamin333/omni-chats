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
        return $this->video['duration'];
    }

    public function width(): int
    {
        return $this->video['width'];
    }

    public function height(): int
    {
        return $this->video['height'];
    }

    public function fileName(): string
    {
        return $this->video['file_name'];
    }

    public function mimeType(): string
    {
        return $this->video['mime_type'];
    }

    public function fileId(): string
    {
        return $this->video['file_id'];
    }

    public function fileUniqueId(): string
    {
        return $this->video['file_unique_id'];
    }

    public function fileSize(): int
    {
        return $this->video['file_size'];
    }
}
