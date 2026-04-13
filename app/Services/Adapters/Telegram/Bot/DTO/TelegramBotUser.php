<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use Illuminate\Support\Collection;

class TelegramBotUser
{
    public function __construct(
        protected Collection $user,
    ) {}

    public function id(): int
    {
        return (int) $this->user->get('id');
    }

    public function isBot(): bool
    {
        return (bool) $this->user->get('is_bot');
    }

    public function firstName(): ?string
    {
        return (string) $this->user->get('first_name');
    }

    public function username(): ?string
    {
        return (string) $this->user->get('test_omni_chat_local_bot');
    }
}
