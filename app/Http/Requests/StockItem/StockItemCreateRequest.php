<?php

namespace App\Http\Requests\StockItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $stock_id
 * @property int $product_id
 * @property int $quantity
 * @property float $unit_price
 */
class StockItemCreateRequest extends FormRequest
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
            'stock_id' => 'required|exists:stocks,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'gte:1',
            'unit_price' => 'required|min:0',
        ];
    }
}
