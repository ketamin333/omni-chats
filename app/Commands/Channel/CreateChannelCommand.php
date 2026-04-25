<?php

namespace App\Commands\Channel;

use App\Enums\AdapterType;
use App\Http\Requests\Channel\StoreRequest;
use Illuminate\Http\UploadedFile;

readonly class CreateChannelCommand
{
    /**
     * Data Transfer Object for CreateChannel write operation.
     *
     * Carries validated input from Request to Handler.
     */
    public function __construct(
        public int    $companyId,
        public int    $adapterId,
        public string $channelName,
        public ?array $credentials,
        public ?array $settings,
    ) {}

    /**
     * Create a CreateChannelCommand instance from a FormRequest.
     */
    public static function fromRequest(StoreRequest $request): self
    {
        return new self(
            companyId: $request->user()->company_id,
            adapterId: $request->adapter_id,
            channelName: $request->channel_name,
            credentials: $request->credentials,
            settings: $request->settings
        );
    }
}
