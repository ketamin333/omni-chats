<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotPhoto
{
    public function __construct(
        protected array $photo
    ) {
        $this->photo = last($this->photo);
    }

    public function fileId(): string
    {
        return (string) $this->photo['file_id'];
    }

    public function fileUniqueId(): string
    {
        return (string) $this->photo['file_id'];
    }

    public function fileSize(): int
    {
        return (string) $this->photo['file_size'];
    }

    public function width(): int
    {
        return (string) $this->photo['width'];
    }

    public function height(): int
    {
        return (string) $this->photo['height'];
    }
}
