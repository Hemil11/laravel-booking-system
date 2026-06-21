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

    public function attributes(): array
    {
        return [
            'staff_id' => __('Staff'),
            'service_id' => __('Service'),
            'date' => __('Date'),
            'time' => __('Time'),
            'notes' => __('Notes'),
        ];
    }

    public function messages(): array
    {
        return [
            'staff_id.required' => __('Please select a staff member.'),
            'service_id.required' => __('Please select a service.'),
            'date.required' => __('Please choose a date.'),
            'date.after_or_equal' => __('Choose today or a future date.'),
            'time.required' => __('Please choose a time slot.'),
            'time.date_format' => __('The selected time is not valid.'),
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'time' => Carbon::createFromFormat('H:i', $this->input('time'))->format('H:i:s'),
        ]);
    }
}
