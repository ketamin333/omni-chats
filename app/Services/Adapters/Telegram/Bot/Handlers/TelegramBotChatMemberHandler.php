<?php

namespace App\Services\Adapters\Telegram\Bot\Handlers;

use App\Models\Channel;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotMyChatMember;
use App\Services\Adapters\Telegram\Bot\Handlers\Contracts\TelegramBotChatMemberHandlerInterface;

class TelegramBotChatMemberHandler implements TelegramBotChatMemberHandlerInterface
{
    public function handle(Channel $channel, TelegramBotMyChatMember $chatMember): void {}
}
