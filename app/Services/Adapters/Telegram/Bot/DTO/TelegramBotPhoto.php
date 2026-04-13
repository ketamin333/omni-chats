<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use Illuminate\Support\Collection;

class TelegramBotPhoto
{
    public function __construct(
        protected Collection $photo
    ) {
        $this->photo = new Collection($this->photo->last());
    }

    public function fileId(): string
    {
        return (string) $this->photo->get('file_id');
    }

    public function fileUniqueId(): string
    {
        return (string) $this->photo->get('file_id');
    }

    public function fileSize(): int
    {
        return (string) $this->photo->get('file_size');
    }

    public function width(): int
    {
        return (string) $this->photo->get('width');
    }

    public function height(): int
    {
        return (string) $this->photo->get('height');
    }
}
