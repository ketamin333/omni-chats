<?php

namespace App\Services\Adapters\Telegram\Bot;

use App\Commands\Contact\CreateContactCommand;
use App\Commands\Conversation\CreateConversationCommand;
use App\Enums\Telegram\TelegramBotUpdateType;
use App\Handlers\Contact\Contracts\CreateContactHandlerInterface;
use App\Handlers\Conversation\Contracts\CreateConversationHandlerInterface;
use App\Models\Channel;
use App\Repositories\Contracts\ConversationRepositoryInterface;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotMessage;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotUpdate;

class TelegramBotUpdateService
{
    public function __construct(
        protected readonly ConversationRepositoryInterface $conversationRepository,
        protected readonly CreateContactHandlerInterface $createContactHandler,
        protected readonly CreateConversationHandlerInterface $createConversationHandler,
    ) {}

    public function process(Channel $channel, TelegramBotUpdate $update): void
    {
        match ($update->type()) {
            TelegramBotUpdateType::MESSAGE => $this->handleMessage($channel, $update->message()),
            default                        => null,
        };
    }

    protected function handleMessage(Channel $channel, ?TelegramBotMessage $message): void
    {
        $chatId = $message->chat()->id();

        $conversation = $this->conversationRepository
            ->findByChannelAndExternalId($channel, $chatId);

        if (!$conversation) {
            $contact = $this->createContactHandler->handle(
                new CreateContactCommand(
                    companyId: $channel->company_id,
                    username: $message->chat()->username(),
                )
            );

            $conversation = $this->createConversationHandler->handle(
                new CreateConversationCommand(
                    contactId: $contact->contact_id,
                    channelId: $channel->channel_id,
                    externalId: $chatId
                )
            );
        }
    }
}
