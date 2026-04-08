<?php

namespace App\Http\Requests\Channel;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'channel_name'      => ['required', 'string', 'max:255'],
//            'provider_type_id'  => ['required', Rule::exists(ChannelType::class, 'channel_type_id')],
            'credentials'       => ['required', 'array'],
        ];
    }
}
