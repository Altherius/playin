<?php

namespace App\Http\Resources;

use App\Models\Store;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property Store $store
 * @property DateTime $start_time
 * @property DateTime $end_time
 * @property ?int $max_capacity
 * @property string $price
 */
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
            'price' => (float) $this->price,
        ];
    }
}
