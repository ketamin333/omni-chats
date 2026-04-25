<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use App\Services\Adapters\Telegram\Bot\DTO\Contracts\TelegramBotFileInterface;
use App\Services\Adapters\Telegram\Bot\DTO\Contracts\TelegramBotNamedFileInterface;

class TelegramBotDocument implements TelegramBotFileInterface, TelegramBotNamedFileInterface
{
    public function __construct(
        protected array $document
    ) {}

    public function fileName(): string
    {
        return $this->document['file_name'];
    }

    public function mimeType(): string
    {
        return $this->document['mime_type'];
    }

    public function fileId(): string
    {
        return $this->document['file_id'];
    }

    public function fileUniqueId(): string
    {
        return $this->document['file_unique_id'];
    }

    public function fileSize(): int
    {
        return $this->document['file_size'];
    }
}
