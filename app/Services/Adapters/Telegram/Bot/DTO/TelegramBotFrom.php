<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use Illuminate\Support\Collection;

class TelegramBotFrom
{
    public function __construct(
        protected Collection $from
    ) {}

    public function id(): int
    {
        return (int) $this->from->get('id');
    }

    public function isBot(): bool
    {
        return (bool) $this->from->get('is_bot');
    }

    public function firstName(): ?string
    {
        return (string) $this->from->get('first_name');
    }

    public function username(): ?string
    {
        return (string) $this->from->get('username');
    }

    public function languageCode(): string
    {
        return (string) $this->from->get('language_code');
    }
}
