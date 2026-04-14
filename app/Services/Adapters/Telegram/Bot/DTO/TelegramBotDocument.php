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
        return (string) $this->document['file_name'];
    }

    public function mimeType(): string
    {
        return (string) $this->document['mime_type'];
    }

    public function fileId(): string
    {
        return (string) $this->document['file_id'];
    }

    public function fileUniqueId(): string
    {
        return (string) $this->document['file_unique_id'];
    }

    public function fileSize(): int
    {
        return (int) $this->document['file_size'];
    }
}
