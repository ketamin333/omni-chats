<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use Illuminate\Support\Collection;

class TelegramBotOldChatMember
{
    public function __construct(
        protected Collection $oldChatMember,
    ) {}

    public function user(): TelegramBotUser
    {
        return new TelegramBotUser(
            new Collection($this->oldChatMember->get('user'))
        );
    }

    public function status(): string
    {
        return (string) $this->oldChatMember->get('status');
    }

    public function untilDate(): int
    {
        return (int) $this->oldChatMember->get('until_date');
    }
}
