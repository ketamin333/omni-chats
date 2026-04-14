<?php

namespace App\Handlers\Attachment;

use App\Commands\Attachment\CreateAttachmentCommand;
use App\Handlers\Attachment\Contracts\CreateAttachmentHandlerInterface;
use App\Models\Attachment;

class CreateAttachmentHandler implements CreateAttachmentHandlerInterface
{
    /**
     * Execute the CreateAttachment action.
     */
    public function handle(CreateAttachmentCommand $command): Attachment
    {
        return Attachment::create([
            'original_name' => $command->originalName,
            'disk'          => $command->disk,
            'path'          => $command->path,
            'mime_type'     => $command->mimeType,
            'size'          => $command->size,
        ]);
    }
}
