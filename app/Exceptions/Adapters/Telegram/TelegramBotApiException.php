<?php

namespace App\Exceptions\Adapters\Telegram;

use App\Exceptions\Adapters\AdapterException;

class TelegramBotApiException extends AdapterException
{
    private function __construct(
        string $message,
        public readonly int $httpCode,
        public readonly int $retryAfter,
    )
    {
        parent::__construct($message);
    }

    public static function fromResponse(int $status, array $body): self
    {
        return new self(
            message: $body['description'] ?? "Telegram Client API error: $status",
            httpCode: $status,
            retryAfter: $body['parameters']['retry_after'] ?? 60,
        );
    }
}
