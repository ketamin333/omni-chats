<?php

namespace App\Commands\Attachment;

use App\Services\Storage\DTO\StoredFile;
use Illuminate\Database\Eloquent\Model;

readonly class CreateAttachmentCommand
{
    /**
     * Data Transfer Object for CreateAttachment write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public Model      $attachable,
        public StoredFile $storedFile,
    ) {}
}
