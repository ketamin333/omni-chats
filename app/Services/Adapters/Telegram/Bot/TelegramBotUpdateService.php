<?php

namespace App\Services\Adapters\Telegram\Bot;

use App\Commands\Contact\CreateContactCommand;
use App\Commands\Conversation\CreateConversationCommand;
use App\Commands\Message\CreateMessageCommand;
use App\Enums\MessageDirection;
use App\Enums\Telegram\TelegramBotUpdateType;
use App\Handlers\Contact\Contracts\CreateContactHandlerInterface;
use App\Handlers\Conversation\Contracts\CreateConversationHandlerInterface;
use App\Handlers\Message\Contracts\CreateMessageHandlerInterface;
use App\Models\Channel;
use App\Models\Contact;
use App\Models\Conversation;
use App\Repositories\Contracts\ConversationRepositoryInterface;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotChat;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotMessage;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotUpdate;

readonly class TelegramBotUpdateService
{
    public function __construct(
        protected ConversationRepositoryInterface    $conversationRepository,
        protected CreateContactHandlerInterface      $createContactHandler,
        protected CreateConversationHandlerInterface $createConversationHandler,
        protected CreateMessageHandlerInterface      $createMessageHandler,
    ) {}

    public function process(Channel $channel, TelegramBotUpdate $update): void
    {
        match ($update->type()) {
            TelegramBotUpdateType::MESSAGE => $this->handleMessage($channel, $update->message()),
            default                        => null,
        };
    }

    protected function handleMessage(Channel $channel, TelegramBotMessage $message): void
    {
        $conversation = $this->conversationRepository->findByChannelAndExternalId($channel, $message->chat()->id())
            ?? $this->createConversation($channel, $message->chat());

        $this->createMessageHandler->handle(
            new CreateMessageCommand(
                conversationId: $conversation->conversation_id,
                externalId: $message->messageId(),
                direction: MessageDirection::INCOMING,
                text: $message->text() ?? $message->caption(),
            )
        );
    }

    protected function createConversation(Channel $channel, TelegramBotChat $chat): Conversation
    {
        $contact = $this->createContact($channel, $chat->username());

        return $this->createConversationHandler->handle(
            new CreateConversationCommand(
                contactId: $contact->contact_id,
                channelId: $channel->channel_id,
                externalId: $chat->id(),
            )
        );
    }

    protected function createContact(Channel $channel, ?string $username = null): Contact
    {
        return $this->createContactHandler->handle(
            new CreateContactCommand(
                companyId: $channel->company_id,
                username: $username,
            )
        );
    }
}
