<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotFrom
{
    public function __construct(
        protected array $from
    ) {}

    public function id(): int
    {
        return $this->from['id'];
    }

    public function isBot(): bool
    {
        return $this->from['is_bot'];
    }

    public function firstName(): ?string
    {
        return $this->from['first_name'] ?? null;
    }

    public function username(): ?string
    {
        return $this->from['username'] ?? null;
    }

    public function languageCode(): string
    {
        return $this->from['language_code'];
    }
}
