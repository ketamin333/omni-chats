<?php

namespace App\Enums\Telegram;

enum TelegramBotUpdateType: string
{
    case MESSAGE = 'message';
    case EDITED_MESSAGE = 'edited_message';
    case MY_CHAT_MEMBER = 'my_chat_member';
    case CALLBACK_QUERY = 'callback_query';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
