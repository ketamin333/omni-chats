<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use Illuminate\Support\Collection;

class TelegramBotNewChatMember
{
    public function __construct(
        protected Collection $newChatMember,
    ) {}

    public function user(): TelegramBotUser
    {
        return new TelegramBotUser(
            new Collection($this->newChatMember->get('user'))
        );
    }

    public function status(): string
    {
        return (string) $this->newChatMember->get('status');
    }
}
