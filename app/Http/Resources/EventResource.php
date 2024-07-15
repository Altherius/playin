<?php

namespace App\Http\Resources;

use App\Models\Store;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property string $name
 * @property Store $store
 * @property DateTime $start_time
 * @property DateTime $end_time
 * @property ?int $max_capacity
 * @property int $registrations_count
 * @property string $price
 */
#[OA\Schema(
    schema: 'Event',
    required: ['id', 'name', 'store'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the event', type: 'integer', nullable: false),
        new OA\Property(property: 'name', description: 'The name of the event', type: 'string', example: 'PPTQ Modern', nullable: false),
        new OA\Property(property: 'store', ref: '#/components/schemas/Store', description: 'The store which manages the event', nullable: false),
        new OA\Property(property: 'start_time', description: 'The time at which the event starts', type: 'string', format: 'date-time', nullable: false),
        new OA\Property(property: 'end_time', description: 'The time at which the event ends', type: 'string', format: 'date-time', nullable: false),
        new OA\Property(property: 'max_capacity', description: 'The maximum number of registrations', type: 'integer', minimum: 0, nullable: false),
        new OA\Property(property: 'registrations_count', description: 'The current number of registrations', type: 'integer', minimum: 0, nullable: false),
        new OA\Property(property: 'price', description: 'The default registration price', type: 'float', minimum: 0, nullable: false),
        new OA\Property(property: 'registrations', ref: '#/components/schemas/Registration', description: 'The list of registrations for this event', nullable: false),
    ]
)]
class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'store' => new StoreResource($this->store),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'max_capacity' => $this->max_capacity,
            'registrations_count' => $this->registrations_count,
            'price' => (float) $this->price,
            'registrations' => RegistrationResource::collection($this->whenLoaded('registrations')),
        ];
    }
}
