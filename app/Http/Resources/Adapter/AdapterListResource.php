<?php

namespace App\Http\Resources\Adapter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdapterListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'adapter_id'      => $this->adapter_id,
            'adapter_name'    => $this->adapter_name,
            'adapter_type'    => $this->adapter_type,
            'slug'            => $this->slug,
        ];
    }
}
