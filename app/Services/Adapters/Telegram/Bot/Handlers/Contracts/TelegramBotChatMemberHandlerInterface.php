<?php

namespace App\Services\Adapters\Telegram\Bot\Handlers\Contracts;

use App\Models\Channel;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotMyChatMember;

interface TelegramBotChatMemberHandlerInterface
{
    public function handle(Channel $channel, TelegramBotMyChatMember $chatMember): void;
}
