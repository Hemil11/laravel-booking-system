<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'staff_id' => ['required', 'integer', 'exists:staffs,id'],
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'time' => Carbon::createFromFormat('H:i', $this->input('time'))->format('H:i:s'),
        ]);
    }
}
