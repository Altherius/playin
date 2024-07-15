<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property string $name
 * @property int $category_id
 */
#[OA\Schema(
    schema: 'CategoryUpdateInput',
    required: ['name', 'category_id'],
    properties: [
        new OA\Property(property: 'name', description: 'The name of the category', type: 'string', nullable: false),
        new OA\Property(property: 'category_id', description: 'The id of the parent category', type: 'string', nullable: true),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for updating a category',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/CategoryUpdateInput'),
    ]
)]
class CategoryUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'category_id' => 'exists:categories,id|nullable',
        ];
    }
}
