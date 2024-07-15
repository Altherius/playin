<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property string $comment
 * @property string $credit
 * @property int $customer_id
 * @property int $collaborator_id
 * @property DateTime $created_at
 */
#[OA\Schema(
    schema: 'StoreCreditHistory',
    required: ['id', 'comment', 'credit', 'customer_id', 'collaborator_id', 'created_at'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the store credit history entry', type: 'integer', nullable: false),
        new OA\Property(property: 'comment', description: 'A comment describing the entry', type: 'string', nullable: true),
        new OA\Property(property: 'credit', description: "The credit added to the customer's balance", type: 'float', nullable: false),
        new OA\Property(property: 'customer_id', description: 'The id of the customer tracked by the entry', type: 'integer', nullable: false),
        new OA\Property(property: 'collaborator_id', description: 'The id of the collaborator responsible for the transaction', type: 'integer', nullable: false),
        new OA\Property(property: 'created_at', description: 'The timestamp of the entry', type: 'string', format: 'date-time', nullable: false),
    ]
)]
class StoreCreditHistoryResource extends JsonResource
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
            'comment' => $this->comment,
            'credit' => (float) $this->credit,
            'customer_id' => $this->customer_id,
            'collaborator_id' => $this->collaborator_id,
            'created_at' => $this->created_at,
        ];
    }
}
