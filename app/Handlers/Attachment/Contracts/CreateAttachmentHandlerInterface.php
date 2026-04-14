<?php

namespace App\Handlers\Attachment\Contracts;

use App\Commands\Attachment\CreateAttachmentCommand;
use App\Models\Attachment;

interface CreateAttachmentHandlerInterface
{
    public function handle(CreateAttachmentCommand $command): Attachment;
}
