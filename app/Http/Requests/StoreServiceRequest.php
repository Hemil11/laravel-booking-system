<?php

namespace App\Http\Requests;

use App\Support\MediaValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120', 'unique:services,name'],
            'duration' => ['required', 'integer', 'min:1', 'max:10080'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'image' => MediaValidation::optionalImage(),
        ];
    }
}
