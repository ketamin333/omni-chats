<?php

namespace App\Services\Adapters\Telegram\Bot;

use App\Commands\Channel\UpdateCredentialsChannelCommand;
use App\Commands\Channel\UpdateStatusChannelCommand;
use App\Enums\ChannelStatus;
use App\Exceptions\Adapters\Telegram\TelegramBotApiException;
use App\Handlers\Channel\Contracts\UpdateCredentialsChannelHandlerInterface;
use App\Handlers\Channel\Contracts\UpdateStatusChannelHandlerInterface;
use App\Models\Channel;
use App\Services\Adapters\Contracts\AdapterHandlerInterface;
use App\Services\Adapters\Contracts\HasCredentialRules;
use App\Services\Adapters\Telegram\Bot;
use App\Services\Adapters\Telegram\Bot\Client\Factories\TelegramBotClientFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TelegramBotAdapterService implements AdapterHandlerInterface, HasCredentialRules
{
    public function __construct(
        private TelegramBotClientFactory $factory,
        private UpdateStatusChannelHandlerInterface $updateStatusChannelHandler,
        private UpdateCredentialsChannelHandlerInterface $updateCredentialsChannelHandler,
    ) {}

    protected function getClient(string $botToken): Bot\Client\Contracts\TelegramBotClientInterface
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
                    'bot_id' => $bot['id'],
                    'bot_username' => $bot['username'],
                    'secret_token' => $secret
                ])
            );

            $this->updateStatusChannelHandler->handle(
                new UpdateStatusChannelCommand($channel, ChannelStatus::ACTIVE)
            );
        } catch (TelegramBotApiException $e) {
            Log::error($e->getMessage());

            $status = match ($e->getHttpCode()) {
                401, 403 => ChannelStatus::BANNED,
                429      => ChannelStatus::RATE_LIMITED,
                404      => ChannelStatus::INVALID_CREDENTIALS,
                default  => ChannelStatus::DISCONNECTED,
            };

            $this->updateStatusChannelHandler->handle(
                new UpdateStatusChannelCommand($channel, $status)
            );
        }
    }

    public function pause(Channel $channel): void
    {
        try {
            $client = $this->getClient($channel->credentials['bot_token']);

            $client->deleteWebhook();
        } catch (TelegramBotApiException $e) {}
    }
}
