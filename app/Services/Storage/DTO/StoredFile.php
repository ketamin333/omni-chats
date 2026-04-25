<?php

namespace App\Services\Storage\DTO;

readonly class StoredFile
{
    public function __construct(
        public string $originalName,
        public string $disk,
        public string $path,
        public string $mimeType,
        public int    $size,
    ) {}
}
