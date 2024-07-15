<?php

namespace App\Http\Requests\Event;

use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property string $name
 * @property int $store_id
 * @property DateTime $start_time
 * @property DateTime $end_time
 * @property int $max_capacity
 * @property float $price
 */
#[OA\Schema(
    schema: 'EventEditInput',
    required: ['name', 'store_id', 'start_time', 'end_time', 'max_capacity', 'price'],
    properties: [
        new OA\Property(property: 'name', description: 'The name of the event', type: 'string', nullable: false),
        new OA\Property(property: 'store_id', description: 'The id of the managing store', type: 'integer', nullable: false),
        new OA\Property(property: 'start_time', description: 'The time at which the event starts', type: 'string', format: 'date-time', nullable: false),
        new OA\Property(property: 'end_time', description: 'The time at which the event ends', type: 'string', format: 'date-time', nullable: false),
        new OA\Property(property: 'max_capacity', description: 'The maximum number of registrations', type: 'integer', minimum: 0, nullable: false),
        new OA\Property(property: 'price', description: 'The default registration price', type: 'float', nullable: false),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for creating or updating an event',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/EventEditInput'),
    ]
)]
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
