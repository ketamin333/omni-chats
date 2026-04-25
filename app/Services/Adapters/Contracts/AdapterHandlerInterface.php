<?php

namespace App\Services\Adapters\Contracts;

use App\Models\Channel;
use App\Models\Message;

interface AdapterHandlerInterface
{
    public function initialize(Channel $channel): void;
    public function reinitialize(Channel $channel): void;
    public function sendMessage(Channel $channel, Message $message): void;
    public function pause(Channel $channel): void;
}
