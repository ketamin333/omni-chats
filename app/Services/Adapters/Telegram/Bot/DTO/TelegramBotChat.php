<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotChat
{
    public function __construct(
        protected array $chat
    ) {}

    public function id(): int
    {
        return $this->chat['id'];
    }

    public function firstName(): ?string
    {
        return $this->chat['first_name'] ?? null;
    }

    public function username(): ?string
    {
        return $this->chat['username'] ?? null;
    }

    public function type(): string
    {
        return $this->chat['type'];
    }
}
