<?php

namespace App\Http\Resources;

use App\Enums\GiftCardStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property string $barcode
 * @property string $value
 * @property GiftCardStatus $status
 */
#[OA\Schema(
    schema: 'GiftCard',
    required: ['id', 'name', 'store'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the gift card', type: 'integer', nullable: false),
        new OA\Property(property: 'barcode', description: 'The barcode of the gift card', type: 'string', example: '0000000000000', nullable: false),
        new OA\Property(property: 'value', description: 'The value of the gift card', type: 'float', nullable: false),
        new OA\Property(
            property: 'status',
            description: 'The status of the gift card',
            type: 'string',
            enum: [GiftCardStatus::INACTIVE, GiftCardStatus::ACTIVE, GiftCardStatus::USED],
            nullable: false
        ),
    ]
)]
class GiftCardResource extends JsonResource
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
            'barcode' => $this->barcode,
            'value' => (float) $this->value,
            'status' => $this->status,
        ];
    }
}
