<?php

namespace App\Http\Requests;

use App\Models\Staff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Staff $staff */
        $staff = $this->route('staff');

        return [
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
                Rule::unique('staffs', 'user_id')->ignore($staff->id),
            ],
            'full_name' => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'bio' => ['nullable', 'string'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'is_active' => ['required', 'in:0,1'],
            'services' => ['nullable', 'array'],
            'services.*' => ['integer', 'exists:services,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $start = $this->input('start_time');
            $end = $this->input('end_time');
            if (! $start || ! $end || $validator->errors()->hasAny(['start_time', 'end_time'])) {
                return;
            }

            $s = \Carbon\Carbon::createFromFormat('H:i', $start);
            $e = \Carbon\Carbon::createFromFormat('H:i', $end);
            if ($e->lte($s)) {
                $validator->errors()->add('end_time', __('End time must be after start time.'));
            }
        });
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'start_time' => \Carbon\Carbon::createFromFormat('H:i', $this->input('start_time'))->format('H:i:s'),
            'end_time' => \Carbon\Carbon::createFromFormat('H:i', $this->input('end_time'))->format('H:i:s'),
        ]);
    }
}
