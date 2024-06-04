<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property bool $validated
 * @property bool $sent
 * @property bool $received
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
        ];
    }
}
