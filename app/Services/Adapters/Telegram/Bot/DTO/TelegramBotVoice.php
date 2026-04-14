<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use App\Services\Adapters\Telegram\Bot\DTO\Contracts\TelegramBotFileInterface;

class TelegramBotVoice implements TelegramBotFileInterface
{
    public function __construct(
        protected array $voice,
    ) {}

    public function duration(): int
    {
        return $this->voice['duration'];
    }

    public function mimeType(): string
    {
        return $this->voice['mime_type'];
    }

    public function fileId(): string
    {
        return $this->voice['file_id'];
    }

    public function fileUniqueId(): string
    {
        return $this->voice['file_unique_id'];
    }

    public function fileSize(): int
    {
        return $this->voice['file_size'];
    }
}
