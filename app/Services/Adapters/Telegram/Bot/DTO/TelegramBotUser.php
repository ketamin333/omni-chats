<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotUser
{
    public function __construct(
        protected array $user,
    ) {}

    public function id(): int
    {
        return (int) $this->user['id'];
    }

    public function isBot(): bool
    {
        return (bool) $this->user['is_bot'];
    }

    public function firstName(): ?string
    {
        return (string) $this->user['first_name'];
    }

    public function username(): ?string
    {
        return (string) $this->user['username'];
    }
}
