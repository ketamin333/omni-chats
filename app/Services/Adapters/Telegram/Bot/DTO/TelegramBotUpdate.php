<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use App\Enums\Telegram\TelegramBotUpdateType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class TelegramBotUpdate
{
    public function __construct(
        protected Collection $data
    ) {}

    public function updateId(): int
    {
        return (int) $this->data->get('update_id');
    }

    public function type(): TelegramBotUpdateType
    {
        /** @var string|null $type */
        $type = $this->data->keys()->first(
            fn ($key) => in_array($key, TelegramBotUpdateType::values())
        );

        if (!$type) {
            throw new RuntimeException('Unknown update type');
        }

        return TelegramBotUpdateType::from($type);
    }

    public function message(): ?TelegramBotMessage
    {
        if (!$this->data->has('message')) {
            return null;
        }

        return new TelegramBotMessage(
            new Collection($this->data->get('message'))
        );
    }
}
