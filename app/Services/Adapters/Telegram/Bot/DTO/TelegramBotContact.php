<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotContact
{
    public function __construct(
        protected array $contact
    ) {}

    public function phoneNumber(): ?string
    {
        return $this->contact['phone_number'] ?? null;
    }

    public function firstName(): ?string
    {
        return $this->contact['first_name'] ?? null;
    }

    public function userId(): int
    {
        return $this->contact['user_id'];
    }
}
