<?php

namespace App\Http\Requests\OrderItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $order_id
 * @property int $product_id
 * @property int $quantity
 * @property float $unit_price
 */
class OrderItemCreateRequest extends FormRequest
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
            'order_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'gte:1',
            'unit_price' => 'required|min:0',
        ];
    }
}
