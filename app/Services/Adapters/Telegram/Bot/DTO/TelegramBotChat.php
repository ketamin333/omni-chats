<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotChat
{
    public function __construct(
        protected array $chat
    ) {}

    public function id(): int
    {
        return (int) $this->chat['id'];
    }

    public function firstName(): ?string
    {
        return (string) $this->chat['first_name'];
    }

    public function username(): ?string
    {
        return (string) $this->chat['username'];
    }

    public function type(): string
    {
        return (string) $this->chat['type'];
    }
}
