<?php

namespace App\Http\Requests\Channel;

use App\Repositories\Contracts\AdapterRepositoryInterface;
use App\Services\Adapters\AdapterResolver;
use App\Services\Adapters\Contracts\HasCredentialRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function __construct(
        private readonly AdapterResolver            $resolver,
        private readonly AdapterRepositoryInterface $repository,
    ) {
        parent::__construct();
    }

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
        $credentialRules = [];

        $adapter = $this->repository->getById($this->adapter_id);

        if ($adapter) {
            $handler = $this->resolver->resolve($adapter);
            $credentialRules = $handler instanceof HasCredentialRules
                ? $handler->rules()
                : ['credentials' => ['nullable', 'array']];
        }

        return array_merge([
            'adapter_id'   => ['required', 'integer', Rule::exists('adapters', 'adapter_id')],
            'channel_name' => ['required', 'string', 'max:255'],
            'settings'     => ['nullable', 'array'],
            'settings.*'   => ['nullable', 'string', 'max:255'],
        ], $credentialRules);
    }
}
