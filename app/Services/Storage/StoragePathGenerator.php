<?php

namespace App\Services\Storage;

use Illuminate\Support\Str;

class StoragePathGenerator
{
    public function generate(string $prefix, string $ext): string
    {
        return sprintf('%s/%s.%s', $prefix, Str::uuid(), $ext);
    }
}
