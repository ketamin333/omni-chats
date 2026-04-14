<?php

namespace App\Services\Adapters\Telegram\Bot\Handlers;

use App\Commands\Attachment\CreateAttachmentCommand;
use App\Commands\Contact\CreateContactCommand;
use App\Commands\Conversation\CreateConversationCommand;
use App\Commands\Message\CreateMessageCommand;
use App\Enums\MessageDirection;
use App\Handlers\Attachment\Contracts\CreateAttachmentHandlerInterface;
use App\Handlers\Contact\Contracts\CreateContactHandlerInterface;
use App\Handlers\Conversation\Contracts\CreateConversationHandlerInterface;
use App\Handlers\Message\Contracts\CreateMessageHandlerInterface;
use App\Models\Channel;
use App\Models\Contact;
use App\Models\Conversation;
use App\Repositories\Contracts\ConversationRepositoryInterface;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotChat;
use App\Services\Adapters\Telegram\Bot\DTO\TelegramBotMessage;
use App\Services\Adapters\Telegram\Bot\Handlers\Contracts\TelegramBotMessageHandlerInterface;
use App\Services\Adapters\Telegram\Bot\TelegramBotFileService;

readonly class TelegramBotMessageHandler implements TelegramBotMessageHandlerInterface
{
    public function __construct(
        protected ConversationRepositoryInterface    $conversationRepository,
        protected CreateConversationHandlerInterface $createConversationHandler,
        protected CreateContactHandlerInterface      $createContactHandler,
        protected CreateMessageHandlerInterface      $createMessageHandler,
        protected TelegramBotFileService             $telegramBotFileService,
        protected CreateAttachmentHandlerInterface   $createAttachmentHandler,
    ) {}

    public function handle(Channel $channel, TelegramBotMessage $message): void
    {
        $conversation = $this->conversationRepository->findByChannelAndExternalId($channel, $message->chat()->id())
            ?? $this->createConversation($channel, $message->chat());

        $createdMessage = $this->createMessageHandler->handle(
            new CreateMessageCommand(
                conversationId: $conversation->conversation_id,
                externalId: $message->messageId(),
                direction: MessageDirection::INCOMING,
                text: $message->text() ?? $message->caption(),
            )
        );

        $file = $message->photo()
            ?? $message->video()
            ?? $message->document()
            ?? $message->voice()
            ?? $message->audio();

        if ($file) {
            $storedFile = $this->telegramBotFileService->store($channel, $file);

            $this->createAttachmentHandler->handle(
                new CreateAttachmentCommand(
                    attachable: $createdMessage,
                    storedFile: $storedFile,
                )
            );
        }
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
