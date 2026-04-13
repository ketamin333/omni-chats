<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

use Illuminate\Support\Collection;

class TelegramBotMessage
{
    public function __construct(
        protected Collection $message,
    ) {}

    public function messageId(): int
    {
        return (int) $this->message->get('message_id');
    }

    public function from(): TelegramBotFrom
    {
        return new TelegramBotFrom(
            new Collection($this->message->get('from'))
        );
    }

    public function chat(): TelegramBotChat
    {
        return new TelegramBotChat(
            new Collection($this->message->get('chat'))
        );
    }

    public function date(): int
    {
        return (int) $this->message->get('date');
    }

    public function mediaGroupId(): ?int
    {
        return (int) $this->message->get('media_group_id');
    }

    public function text(): ?string
    {
        return (string) $this->message->get('text');
    }

    public function caption(): ?string
    {
        return (string) $this->message->get('caption');
    }

    public function document(): ?TelegramBotDocument
    {
        if (!$this->message->has('document')) {
            return null;
        }

        return new TelegramBotDocument(
            new Collection($this->message->get('document'))
        );
    }

    public function photo(): ?TelegramBotPhoto
    {
        if (!$this->message->has('photo')) {
            return null;
        }

        return new TelegramBotPhoto(
            new Collection($this->message->get('photo'))
        );
    }
}
