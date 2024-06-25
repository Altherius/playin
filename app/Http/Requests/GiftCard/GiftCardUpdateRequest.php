<?php

namespace App\Http\Requests\GiftCard;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $barcode
 * @property float $value
 */
class GiftCardUpdateRequest extends FormRequest
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
            'barcode' => 'required|string|size:13',
            'value' => 'required|numeric|gte:0',
        ];
    }
}
