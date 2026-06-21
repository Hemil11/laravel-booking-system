<?php

namespace App\Http\Requests;

use App\Support\MediaValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission('manage_services') ?? false;
    }

    public function rules(): array
    {
        $service = $this->route('service');

        return [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('services', 'name')->ignore($service?->id),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'duration' => ['required', 'integer', 'min:1', 'max:10080'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'image' => MediaValidation::optionalImage(),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Name'),
            'description' => __('Description'),
            'duration' => __('Duration'),
            'price' => __('Price'),
            'image' => __('Image'),
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => __('Another service already uses this name.'),
        ];
    }
}
