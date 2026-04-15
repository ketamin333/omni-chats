<?php

namespace App\Services\Adapters\Telegram\Bot\Client;

use App\Exceptions\Adapters\Telegram\TelegramBotApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
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

    private function throwIfFailed(Response $response): void
    {
        if ($response->failed()) {
            throw TelegramBotApiException::fromResponse($response->status(), $response->json() ?? []);
        }
    }

    public function getMe(): array
    {
        $response = $this->http()->get('/getMe');
        $this->throwIfFailed($response);

        return $response->json();
    }

    public function sendMessage(int $chatId, string $text, array $options = []): array
    {
        $response = $this->http()->post('/sendMessage', array_merge(['chat_id' => $chatId, 'text' => $text,], $options));
        $this->throwIfFailed($response);

        return $response->json();
    }

    public function setWebhook(string $url, array $options = []): array
    {
        $response = $this->http()->post('/setWebhook', array_merge(['url' => $url], $options));
        $this->throwIfFailed($response);

        return $response->json();
    }

    public function deleteWebhook(array $options = []): array
    {
        $response = $this->http()->get('/deleteWebhook', $options);
        $this->throwIfFailed($response);

        return $response->json();
    }

    public function getFile(string $fileId): array
    {
        $response = $this->http()->get('/getFile', ['file_id' => $fileId]);
        $this->throwIfFailed($response);

        return $response->json();
    }

    public function downloadFile(string $filePath): string
    {
        $response = $this->fileHttp()->get($filePath);
        $this->throwIfFailed($response);

        return $response->body();
    }
}
