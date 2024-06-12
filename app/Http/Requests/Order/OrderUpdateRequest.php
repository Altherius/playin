<?php

namespace App\Http\Requests\Order;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property bool $validated
 * @property bool $sent
 * @property bool $received
 * @property PaymentMode $payment_mode
 * @property PaymentStatus $payment_status
 */
class OrderUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'validated' => 'required|boolean|accepted_if:sent,true',
            'sent' => 'required|boolean|accepted_if:received,true',
            'received' => 'required|boolean',
            'payment_mode' => 'present',
            'payment_status' => 'required',
        ];
    }
}
