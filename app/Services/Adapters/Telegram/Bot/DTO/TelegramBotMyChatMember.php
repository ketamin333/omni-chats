<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use Illuminate\Support\Collection;

class TelegramBotMyChatMember
{
    public function __construct(
        protected Collection $myChatMember,
    ) {}

    public function chat(): TelegramBotChat
    {
        return new TelegramBotChat(
            new Collection($this->myChatMember->get('chat')),
        );
    }

    public function from(): TelegramBotFrom
    {
        return new TelegramBotFrom(
            new Collection($this->myChatMember->get('from')),
        );
    }

    public function date(): int
    {
        return (int) $this->myChatMember->get('date');
    }

    public function oldChatMember(): TelegramBotOldChatMember
    {
        return new TelegramBotOldChatMember(
            new Collection($this->myChatMember->get('old_chat_member'))
        );
    }

    protected function newChatMember(): TelegramBotNewChatMember
    {
        return new TelegramBotNewChatMember(
            new Collection($this->myChatMember->get('new_chat_member')),
        );
    }
}
