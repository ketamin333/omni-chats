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
            'attachable_type' => $command->attachable->getMorphClass(),
            'attachable_id'   => $command->attachable->getKey(),
            'original_name'   => $command->storedFile->originalName,
            'disk'            => $command->storedFile->disk,
            'path'            => $command->storedFile->path,
            'mime_type'       => $command->storedFile->mimeType,
            'size'            => $command->storedFile->size,
        ]);
    }
}
