<?php

namespace App\Services\Channels\Telegram;

use App\Models\Channel;
use App\Services\Channels\ChannelServiceInterface;
use App\Services\Telegram\TelegramBotClient;

class TelegramBotChannelService implements ChannelServiceInterface
{
    public function check(array $credentials): void
    {
        $client = new TelegramBotClient($credentials['bot_token']);
        $client->getMe();
    }

    public function setup(Channel $channel): void
    {
        $client = new TelegramBotClient($channel->credentials['bot_token']);

        $client->deleteWebhook();
        $client->setWebhook(route('webhook.telegram.bot'));
    }
}
