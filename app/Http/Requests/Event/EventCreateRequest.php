<?php

namespace App\Http\Requests\Event;

use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property int $store_id
 * @property DateTime $start_time
 * @property DateTime $end_time
 * @property int $max_capacity
 * @property float $price
 */
class EventCreateRequest extends FormRequest
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
            'name' => 'required',
            'store_id' => 'required|exists:stores,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'max_capacity' => 'gt:0',
            'price' => 'required|gte:0',
        ];
    }
}
