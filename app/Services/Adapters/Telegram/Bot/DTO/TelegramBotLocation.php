<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotLocation
{
    public function __construct(
        protected array $location
    ) {}

    public function latitude(): float
    {
        return (float) $this->location['latitude'];
    }

    public function longitude(): float
    {
        return (float) $this->location['longitude'];
    }
}
