<?php

namespace App\Services\Telegram;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class TelegramBotClient
{
    protected string $baseUrl = 'https://api.telegram.org/bot';

    public function __construct(
        protected string $botToken,
    ) {}

    public function getMe(): array
    {
        return $this->request('getMe');
    }

    public function setWebhook(string $url, array $options = []): array
    {
        return $this->request('setWebhook', array_merge(['url' => $url], $options));
    }

    public function deleteWebhook(): array
    {
        return $this->request('deleteWebhook');
    }

    protected function request(string $method, array $payload = []): array
    {
        $response = Http::post("{$this->baseUrl}{$this->botToken}/{$method}", $payload);

        if (!$response->successful() || !$response->json('ok')) {
            throw new RuntimeException($response->json('description') ?? 'Telegram API error');
        }

        return $response->json('result');
    }
}
