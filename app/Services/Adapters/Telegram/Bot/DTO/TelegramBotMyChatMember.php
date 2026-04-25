<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotMyChatMember
{
    public function __construct(
        protected array $myChatMember,
    ) {}

    public function chat(): TelegramBotChat
    {
        return new TelegramBotChat($this->myChatMember['chat']);
    }

    public function from(): TelegramBotFrom
    {
        return new TelegramBotFrom($this->myChatMember['from']);
    }

    public function date(): int
    {
        return $this->myChatMember['date'];
    }

    public function oldChatMember(): TelegramBotOldChatMember
    {
        return new TelegramBotOldChatMember($this->myChatMember['old_chat_member']);
    }

    public function newChatMember(): TelegramBotNewChatMember
    {
        return new TelegramBotNewChatMember($this->myChatMember['new_chat_member']);
    }
}
