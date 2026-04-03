<?php

namespace App\Http\Requests\Channel;

use App\Enums\ChannelType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChannelStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'channel_name' => ['required', 'string', 'max:255'],
            'type'         => ['required', Rule::enum(ChannelType::class)],
            'avatar'       => ['nullable', 'image', 'max:2048'],
            'credentials'  => ['required', 'array'],
        ];
    }
}
