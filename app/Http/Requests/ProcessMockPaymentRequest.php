<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProcessMockPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $invoice = $this->route('invoice');

        return $invoice !== null && $this->user()?->can('processPayment', $invoice) === true;
    }

    public function rules(): array
    {
        return [
            'result' => ['required', Rule::in(['success', 'failure'])],
        ];
    }
}
