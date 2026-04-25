<?php

namespace App\Services\Adapters\Telegram\Bot;

use App\Commands\Channel\UpdateCredentialsChannelCommand;
use App\Commands\Channel\UpdateStatusChannelCommand;
use App\Commands\Message\UpdateMessageCommand;
use App\Commands\Message\UpdateStatusMessageCommand;
use App\Enums\ChannelStatus;
use App\Enums\MessageStatus;
use App\Exceptions\Adapters\AdapterAuthException;
use App\Exceptions\Adapters\AdapterConnectionException;
use App\Exceptions\Adapters\AdapterRateLimitException;
use App\Exceptions\Adapters\Telegram\TelegramBotApiException;
use App\Handlers\Channel\Contracts\UpdateCredentialsChannelHandlerInterface;
use App\Handlers\Channel\Contracts\UpdateStatusChannelHandlerInterface;
use App\Handlers\Message\Contracts\UpdateMessageHandlerInterface;
use App\Handlers\Message\Contracts\UpdateStatusMessageHandlerInterface;
use App\Models\Channel;
use App\Models\Message;
use App\Services\Adapters\Contracts\AdapterHandlerInterface;
use App\Services\Adapters\Contracts\HasCredentialRules;
use App\Services\Adapters\Telegram\Bot\Client\TelegramBotClientFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

readonly class TelegramBotAdapterService implements AdapterHandlerInterface, HasCredentialRules
{
    public function __construct(
        private TelegramBotClientFactory                 $factory,
        private UpdateStatusChannelHandlerInterface      $updateStatusChannelHandler,
        private UpdateCredentialsChannelHandlerInterface $updateCredentialsChannelHandler,
        private UpdateStatusMessageHandlerInterface      $updateStatusMessageHandler,
        private UpdateMessageHandlerInterface            $updateMessageHandler,
    ) {}

    private function getClient(string $botToken): Client\TelegramBotClientInterface
    {
        return $this->factory->make($botToken);
    }

    public function rules(): array
    {
        return [
            'credentials' => ['required', 'array'],
            'credentials.bot_token' => [
                'required', 'string', 'min:10',
                Rule::unique('channels', 'credentials->bot_token')
            ],
        ];
    }

    public function initialize(Channel $channel): void
    {
        $this->updateStatusChannelHandler->handle(
            new UpdateStatusChannelCommand($channel, ChannelStatus::CONNECTING)
        );
    }

    public function reinitialize(Channel $channel): void
    {
        try {
            $client = $this->getClient($channel->credentials['bot_token']);
            $bot = $client->getMe()['result'];

            $client->deleteWebhook();
            $client->setWebhook(
                'https://webhook.site/d82687af-1ff6-4caf-b981-8ebad19ea4df',
                ['secret_token' => $secret = Str::random(32)]
            );

            $this->updateCredentialsChannelHandler->handle(
                new UpdateCredentialsChannelCommand($channel, [
                    'bot_id'       => $bot['id'],
                    'bot_username' => $bot['username'],
                    'secret_token' => $secret
                ])
            );

            $this->updateStatusChannelHandler->handle(
                new UpdateStatusChannelCommand($channel, ChannelStatus::ACTIVE)
            );
        } catch (TelegramBotApiException $e) {
            $this->handleApiException($e);
        }
    }

    public function sendMessage(Channel $channel, Message $message): void
    {
        try {
            $client = $this->getClient($channel->credentials['bot_token']);
            $response = $client->sendMessage(
                $message->conversation->external_id,
                $message->text
            );

            $this->updateStatusMessageHandler->handle(
                new UpdateStatusMessageCommand($message, MessageStatus::SENT)
            );
            $this->updateMessageHandler->handle(
                new UpdateMessageCommand($message, $response['result']['message_id'])
            );
        } catch (TelegramBotApiException $e) {
            $this->updateStatusMessageHandler->handle(
                new UpdateStatusMessageCommand($message, MessageStatus::FAILED)
            );

            $this->handleApiException($e);
        }
    }

    public function pause(Channel $channel): void
    {
        try {
            $client = $this->getClient($channel->credentials['bot_token']);
            $client->deleteWebhook();
        } catch (TelegramBotApiException $e) {
            $this->handleApiException($e);
        }
    }

    private function handleApiException(TelegramBotApiException $e): never
    {
        throw match (true) {
            $e->httpCode === 401 => new AdapterAuthException(),
            $e->httpCode === 429 => new AdapterRateLimitException($e->retryAfter),
            default              => new AdapterConnectionException(),
        };
    }
}
