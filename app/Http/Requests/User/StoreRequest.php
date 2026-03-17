<?php

namespace App\Http\Requests\User;

use App\Enums\Role;
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
            'username' => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'max:255'],
            'avatar'   => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', Rule::enum(Role::class)],
        ];
    }
}
