<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotMessage
{
    public function __construct(
        protected array $message,
    ) {}

    public function messageId(): int
    {
        return $this->message['message_id'];
    }

    public function from(): TelegramBotFrom
    {
        return new TelegramBotFrom($this->message['from']);
    }

    public function chat(): TelegramBotChat
    {
        return new TelegramBotChat($this->message['chat']);
    }

    public function date(): int
    {
        return $this->message['date'];
    }

    public function mediaGroupId(): ?int
    {
        return $this->message['media_group_id'] ?? null;
    }

    public function text(): ?string
    {
        return $this->message['text'] ?? null;
    }

    public function caption(): ?string
    {
        return $this->message['caption'] ?? null;
    }

    public function document(): ?TelegramBotDocument
    {
        if (!array_key_exists('document', $this->message)) {
            return null;
        }

        return new TelegramBotDocument($this->message['document']);
    }

    public function photo(): ?TelegramBotPhoto
    {
        if (!array_key_exists('photo', $this->message)) {
            return null;
        }

        return new TelegramBotPhoto($this->message['photo']);
    }

    public function voice(): ?TelegramBotVoice
    {
        if (!array_key_exists('voice', $this->message)) {
            return null;
        }

        return new TelegramBotVoice($this->message['voice']);
    }

    public function audio(): ?TelegramBotAudio
    {
        if (!array_key_exists('audio', $this->message)) {
            return null;
        }

        return new TelegramBotAudio($this->message['audio']);
    }

    public function video(): ?TelegramBotVideo
    {
        if (!array_key_exists('video', $this->message)) {
            return null;
        }

        return new TelegramBotVideo($this->message['video']);
    }

    public function location(): ?TelegramBotLocation
    {
        if (!array_key_exists('location', $this->message)) {
            return null;
        }

        return new TelegramBotLocation($this->message['location']);
    }

    public function contact(): ?TelegramBotContact
    {
        if (!array_key_exists('contact', $this->message)) {
            return null;
        }

        return new TelegramBotContact($this->message['contact']);
    }
}
