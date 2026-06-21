<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateAdminUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission('manage_users') ?? false;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role_ids' => ['nullable', 'array'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Full name'),
            'email' => __('Email'),
            'password' => __('Password'),
            'role_ids' => __('Roles'),
            'role_ids.*' => __('Role'),
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => __('This email address is already in use.'),
        ];
    }
}
