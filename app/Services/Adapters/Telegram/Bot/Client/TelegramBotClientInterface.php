<?php

namespace App\Services\Adapters\Telegram\Bot\Client;

interface TelegramBotClientInterface
{
    public function getMe(): array;
    public function sendMessage(int $chatId, string $text, array $options = []): array;
    public function setWebhook(string $url, array $options = []): array;
    public function deleteWebhook(array $options = []): array;
    public function getFile(string $fileId): array;
    public function downloadFile(string $filePath): string;
}
