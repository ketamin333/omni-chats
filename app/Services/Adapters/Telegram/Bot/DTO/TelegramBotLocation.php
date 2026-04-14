<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotLocation
{
    public function __construct(
        protected array $location
    ) {}

    public function latitude(): float
    {
        return $this->location['latitude'];
    }

    public function longitude(): float
    {
        return $this->location['longitude'];
    }
}
