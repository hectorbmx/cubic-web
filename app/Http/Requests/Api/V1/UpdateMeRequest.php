<?php

namespace App\Http\Requests\Api\V1;
// namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name'           => ['sometimes', 'string', 'max:120'],
            'last_name'      => ['sometimes', 'nullable', 'string', 'max:120'],
            'phone'          => ['sometimes', 'nullable', 'string', 'max:30'],
            'birth_date'     => ['sometimes', 'nullable', 'date'],
            'email'          => ['sometimes', 'email', 'max:190', Rule::unique('users','email')->ignore($userId)],
            'photo_url'      => ['sometimes', 'nullable', 'url'],
            // Si manejas relación con cliente por id (con cuidado):
            // 'client_id'   => ['sometimes', 'nullable', 'exists:clientes,id'],

            // Evitar que cambien campos sensibles por aquí:
            // 'password', 'roles', 'is_active', etc. NO van en este endpoint.
        ];
    }
}
