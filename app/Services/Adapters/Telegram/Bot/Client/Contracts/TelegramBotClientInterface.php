<?php

namespace App\Services\Adapters\Telegram\Bot\Client\Contracts;

interface TelegramBotClientInterface
{
    public function getMe(): array;
    public function setWebhook(string $url, array $options = []): array;
    public function deleteWebhook(array $options = []): array;
    public function getFile(string $fileId): array;
    public function downloadFile(string $filePath): string;
}
