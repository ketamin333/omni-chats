<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use App\Enums\Telegram\TelegramBotUpdateType;
use RuntimeException;

class TelegramBotUpdate
{
    public function __construct(
        protected array $data
    ) {}

    public function updateId(): int
    {
        return (int) $this->data['update_id'];
    }

    public function type(): TelegramBotUpdateType
    {
        foreach (TelegramBotUpdateType::values() as $value) {
            if (array_key_exists($value, $this->data)) {
                return TelegramBotUpdateType::from($value);
            }
        }

        throw new RuntimeException('Unknown update type');
    }

    public function message(): ?TelegramBotMessage
    {
        if (!array_key_exists('message', $this->data)) {
            return null;
        }

        return new TelegramBotMessage($this->data['message']);
    }

    public function myChatMember(): ?TelegramBotMyChatMember
    {
        if (!array_key_exists('my_chat_member', $this->data)) {
            return null;
        }

        return new TelegramBotMyChatMember($this->data['my_chat_member']);
    }
}
