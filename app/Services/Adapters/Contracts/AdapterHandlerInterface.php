<?php

namespace App\Services\Adapters\Contracts;

use App\Models\Channel;

interface AdapterHandlerInterface
{
    public function initialize(Channel $channel): void;
    public function reinitialize(Channel $channel): void;
    public function pause(Channel $channel): void;
}
