<?php

namespace App\Services\Adapters\Telegram\Bot\DTO;

class TelegramBotEditedMessage extends TelegramBotMessage
{
    public function __construct(
        protected array $editedMessage
    ) {
        parent::__construct($this->editedMessage);
    }

    public function editDate(): int
    {
        return $this->editedMessage['edit_date'];
    }
}
