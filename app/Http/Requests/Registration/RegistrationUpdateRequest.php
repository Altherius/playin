<?php

namespace App\Http\Requests\Registration;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property int $event_id
 * @property int $user_id
 * @property bool $paid
 */
#[OA\Schema(
    schema: 'RegistrationUpdateInput',
    required: ['event_id', 'user_id', 'paid'],
    properties: [
        new OA\Property(property: 'event_id', ref: '#/components/schemas/Event', description: 'The event linked to the registration', nullable: false),
        new OA\Property(property: 'user_id', ref: '#/components/schemas/User', description: 'The user registered to the event', nullable: false),
        new OA\Property(property: 'paid', description: 'Is the registration paid?', type: 'boolean', nullable: false),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for updating a registration',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/RegistrationUpdateInput'),
    ]
)]
class RegistrationUpdateRequest extends FormRequest
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
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'paid' => 'boolean',
        ];
    }
}
