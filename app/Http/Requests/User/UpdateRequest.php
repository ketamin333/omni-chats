<?php

namespace App\Http\Requests\User;

use App\Enums\Role;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'username' => ['sometimes', 'string', 'max:255'],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed', 'max:255'],
            'avatar'   => ['sometimes', 'nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'phone'    => ['sometimes', 'nullable', 'string', 'max:20'],
            'role'     => ['sometimes', Rule::enum(Role::class)],
        ];
    }
}
