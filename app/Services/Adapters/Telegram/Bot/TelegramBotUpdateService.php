<?php

namespace App\Services\Adapters\Telegram\Bot;

use App\Enums\Telegram\TelegramBotUpdateType;
use App\Models\Channel;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotUpdate;
use App\Services\Adapters\Telegram\Bot\Handlers\Contracts\TelegramBotChatMemberHandlerInterface;
use App\Services\Adapters\Telegram\Bot\Handlers\Contracts\TelegramBotMessageHandlerInterface;

readonly class TelegramBotUpdateService
{
    public function __construct(
        protected TelegramBotMessageHandlerInterface $telegramBotMessageHandler,
        protected TelegramBotChatMemberHandlerInterface $telegramBotChatMemberHandler,
    ) {}

    public function process(Channel $channel, TelegramBotUpdate $update): void
    {
        match ($update->type()) {
            TelegramBotUpdateType::MESSAGE        => $this->telegramBotMessageHandler->handle($channel, $update->message()),
            TelegramBotUpdateType::MY_CHAT_MEMBER => $this->telegramBotChatMemberHandler->handle($channel, $update->myChatMember()),
            default                               => null,
        };
    }
}
