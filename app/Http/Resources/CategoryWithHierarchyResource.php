<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property string $name
 * @property Category $parent
 */
#[OA\Schema(
    schema: 'Category',
    required: ['id', 'name', 'parent'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the category', type: 'integer', nullable: false),
        new OA\Property(property: 'name', description: 'The name of the category', type: 'string', example: 'Boosters', nullable: false),
        new OA\Property(property: 'parent', ref: '#/components/schemas/Category', description: 'The mother category', nullable: true),
    ]
)]
class CategoryWithHierarchyResource extends JsonResource
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
            'parent' => new CategoryWithHierarchyResource($this->parent),
        ];
    }
}
