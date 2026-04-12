<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use Illuminate\Support\Collection;

class TelegramBotChat
{
    public function __construct(
        protected Collection $chat
    ) {}

    public function id(): int
    {
        return (int) $this->chat->get('id');
    }

    public function firstName(): ?string
    {
        return (string) $this->chat->get('first_name');
    }

    public function username(): ?string
    {
        return (string) $this->chat->get('username');
    }

    public function type(): string
    {
        return (string) $this->chat->get('type');
    }
}
