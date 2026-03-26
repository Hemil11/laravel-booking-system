<?php

namespace App\Http\Requests;

use App\Support\MediaValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('password') === '') {
            $this->merge(['password' => null]);
        }
    }

    public function rules(): array
    {
        $user = $this->user();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'avatar' => MediaValidation::optionalImage(),
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];
    }
}
