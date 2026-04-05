<?php

namespace App\Commands\Channel;

use App\Enums\ChannelType;
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
        public int           $companyId,
        public string        $channelName,
        public ChannelType   $type,
        public array         $credentials,
        public ?UploadedFile $avatar
    ) {}

    /**
     * Create a CreateChannelCommand instance from a FormRequest.
     */
    public static function fromRequest(StoreRequest $request): self
    {
        return new self(
            companyId: $request->user()->company_id,
            channelName: $request->channel_name,
            type: ChannelType::from($request->type),
            credentials: $request->credentials,
            avatar: $request->file('avatar'),
        );
    }
}
