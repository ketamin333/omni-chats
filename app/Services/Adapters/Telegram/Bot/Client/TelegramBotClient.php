<?php

namespace App\Services\Adapters\Telegram\Bot\Client;

use App\Exceptions\Adapters\Telegram\TelegramBotApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class TelegramBotClient implements TelegramBotClientInterface
{
    protected string $baseUrl = 'https://api.telegram.org/bot';
    protected string $fileUrl = 'https://api.telegram.org/file/bot';

    public function __construct(
        protected string $botToken,
    ) {}

    protected function http(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl . $this->botToken)
            ->withOptions($this->httpOptions());
    }

    protected function fileHttp(): PendingRequest
    {
        return Http::baseUrl($this->fileUrl . $this->botToken)
            ->withOptions($this->httpOptions());
    }

    protected function httpOptions(): array
    {
        return ['proxy' => config('services.telegram.proxy')];
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

    public function getFile(string $fileId): array
    {
        $response = $this->http()->get('/getFile', ['file_id' => $fileId]);

        if ($response->failed()) {
            throw TelegramBotApiException::fromStatus($response->status());
        }

        return $response->json();
    }

    public function downloadFile(string $filePath): string
    {
        $response = $this->fileHttp()->get($filePath);

        if ($response->failed()) {
            throw TelegramBotApiException::fromStatus($response->status());
        }

        return $response->body();
    }
}
