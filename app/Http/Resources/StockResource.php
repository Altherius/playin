<?php

namespace App\Http\Resources;

use App\Models\StockItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property User $retailer
 * @property Collection<StockItem> $items
 */
class StockResource extends JsonResource
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
            'retailer' => route('users.show', [$this->retailer->id]),
            'validated' => $request->validated,
            'sent' => $request->sent,
            'received' => $request->received,
            'total_price' => $this->items->reduce(fn ($carry, $item) => $carry + ($item->quantity * $item->unit_price), 0),
            'items' => StockItemResource::collection($this->items),
            'address' => new AddressResource($this->address),
            'links' => [
                'show' => route('stocks.show', [$this->id]),
            ],
        ];
    }
}
