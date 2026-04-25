<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotUser
{
    public function __construct(
        protected array $user,
    ) {}

    public function id(): int
    {
        return $this->user['id'];
    }

    public function isBot(): bool
    {
        return $this->user['is_bot'];
    }

    public function firstName(): ?string
    {
        return $this->user['first_name'] ?? null;
    }

    public function username(): ?string
    {
        return $this->user['username'] ?? null;
    }
}
