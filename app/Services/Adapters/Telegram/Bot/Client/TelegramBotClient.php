<?php

namespace App\Services\Adapters\Telegram\Bot\Client;

use App\Exceptions\Adapters\Telegram\TelegramBotApiException;
use App\Services\Adapters\Telegram\Bot\Client\Contracts\TelegramBotClientInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class TelegramBotClient implements TelegramBotClientInterface
{
    protected string $baseUrl = 'https://api.telegram.org/bot';

    public function __construct(
        protected string $botToken,
    ) {}

    protected function http(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl . $this->botToken)
            ->withOptions(['proxy' => config('services.telegram.proxy')]);
    }

    public function getMe(): array
    {
        $response = $this->http()->get('/getMe');

        if ($response->failed()) {
            throw TelegramBotApiException::fromStatus($response->status());
        }

        return $response->json();
    }

    public function setWebhook(string $url, array $options = []): array
    {
        $response = $this->http()->post('/setWebhook', array_merge(['url' => $url], $options));

        if ($response->failed()) {
            throw TelegramBotApiException::fromStatus($response->status());
        }

        return $response->json();
    }

    public function deleteWebhook(array $options = []): array
    {
        $response = $this->http()->get('/deleteWebhook', $options);

        if ($response->failed()) {
            throw TelegramBotApiException::fromStatus($response->status());
        }

        return $response->json();
    }
}
