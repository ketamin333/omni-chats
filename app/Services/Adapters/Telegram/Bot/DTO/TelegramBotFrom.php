<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotFrom
{
    public function __construct(
        protected array $from
    ) {}

    public function id(): int
    {
        return (int) $this->from['id'];
    }

    public function isBot(): bool
    {
        return (bool) $this->from['is_bot'];
    }

    public function firstName(): ?string
    {
        return (string) $this->from['first_name'];
    }

    public function username(): ?string
    {
        return (string) $this->from['username'];
    }

    public function languageCode(): string
    {
        return (string) $this->from['language_code'];
    }
}
