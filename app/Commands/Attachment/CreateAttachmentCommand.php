<?php

namespace App\Commands\Attachment;

readonly class CreateAttachmentCommand
{
    /**
     * Data Transfer Object for CreateAttachment write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public string $originalName,
        public string $disk,
        public string $path,
        public string $mimeType,
        public int    $size,
    ) {}
}
