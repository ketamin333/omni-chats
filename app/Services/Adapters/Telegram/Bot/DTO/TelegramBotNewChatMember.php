<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotNewChatMember
{
    public function __construct(
        protected array $newChatMember,
    ) {}

    public function user(): TelegramBotUser
    {
        return new TelegramBotUser($this->newChatMember['user']);
    }

    public function status(): string
    {
        return (string) $this->newChatMember['status'];
    }
}
