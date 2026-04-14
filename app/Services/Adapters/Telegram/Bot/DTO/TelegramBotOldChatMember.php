<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotOldChatMember
{
    public function __construct(
        protected array $oldChatMember,
    ) {}

    public function user(): TelegramBotUser
    {
        return new TelegramBotUser($this->oldChatMember['user']);
    }

    public function status(): string
    {
        return (string) $this->oldChatMember['status'];
    }

    public function untilDate(): int
    {
        return (int) $this->oldChatMember['until_date'];
    }
}
