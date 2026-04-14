<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotContact
{
    public function __construct(
        protected array $contact
    ) {}

    public function phoneNumber(): ?string
    {
        return (string) $this->contact['phone_number'];
    }

    public function firstName(): ?string
    {
        return (string) $this->contact['first_name'];
    }

    public function userId(): int
    {
        return (int) $this->contact['user_id'];
    }
}
