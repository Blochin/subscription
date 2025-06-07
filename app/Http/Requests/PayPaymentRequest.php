<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayPaymentRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $cardRequired = !$this->filled('payment_token');

        return [
            'webhook_name' => 'required|string',
            'payment_token' => 'nullable|string',
            'card_number' => ($cardRequired ? 'required' : 'nullable') . '|string|size:16',
            'expiration' => ($cardRequired ? 'required' : 'nullable') . '|string|regex:/^\d{2}\/\d{2}$/',
            'cvv' => ($cardRequired ? 'required' : 'nullable') . '|string|size:3',
        ];
    }
}
