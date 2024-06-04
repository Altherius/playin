<?php

namespace App\Http\Requests\Address;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $address_name
 * @property string $recipient_name
 * @property string $street
 * @property string $postal_code
 * @property string $locality
 * @property string $country
 */
class AddressCreateRequest extends FormRequest
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
            'address_name' => 'required|string',
            'recipient_name' => 'required|string',
            'street' => 'required|string',
            'postal_code' => 'required|string',
            'locality' => 'required|string',
            'country' => 'required|string',
        ];
    }
}
