<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
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
            'sort_field' => ['nullable', Rule::in(['username', 'email', 'created_at'])],
            'sort_order' => ['nullable', Rule::in(['asc', 'desc'])],
            'search'     => ['nullable', 'string', 'max:255'],
        ];
    }
}
