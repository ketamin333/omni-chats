<?php

namespace App\Exceptions\Adapters\Telegram;

use App\Exceptions\Adapters\AdapterException;

class TelegramBotApiException extends AdapterException
{
    public static function fromStatus(int $status): self
    {
        return new self("Telegram API request failed with status $status", $status);
    }
}
