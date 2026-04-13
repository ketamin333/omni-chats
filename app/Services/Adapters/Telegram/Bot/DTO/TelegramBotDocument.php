<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use Illuminate\Support\Collection;

class TelegramBotDocument
{
    public function __construct(
        protected Collection $document
    ) {}

    public function fileName(): string
    {
        return (string) $this->document->get('file_name');
    }

    public function mimeType(): string
    {
        return (string) $this->document->get('mime_type');
    }

    public function fileId(): string
    {
        return (string) $this->document->get('file_id');
    }

    public function fileUniqueId(): string
    {
        return (string) $this->document->get('file_unique_id');
    }

    public function fileSize(): int
    {
        return (int) $this->document->get('file_size');
    }
}
