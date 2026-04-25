<?php

namespace App\Http\Resources\Concerns;

trait HasTimestamps
{
    protected function getTimestamps(): array
    {
        return [
            'created_at' => $this->created_at?->unix(),
            'updated_at' => $this->updated_at?->unix(),
        ];
    }
}
