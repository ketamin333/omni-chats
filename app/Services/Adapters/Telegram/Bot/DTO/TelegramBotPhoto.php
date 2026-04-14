<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use App\Services\Adapters\Telegram\Bot\DTO\Contracts\TelegramBotFileInterface;

class TelegramBotPhoto implements TelegramBotFileInterface
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
        return (string) $this->photo['file_unique_id'];
    }

    public function fileSize(): int
    {
        return (int) $this->photo['file_size'];
    }

    public function width(): int
    {
        return (int) $this->photo['width'];
    }

    public function height(): int
    {
        return (int) $this->photo['height'];
    }
}
