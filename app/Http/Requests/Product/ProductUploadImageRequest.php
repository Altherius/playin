<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\Schema;

/**
 * @property string $name
 * @property float $price
 */
#[OA\Schema(
    schema: 'ProductUploadImageInput',
    required: ['image'],
    properties: [
        new OA\Property(property: 'image', description: 'The file containing the image of the product', type: 'string', format: 'binary', nullable: false),
        new OA\Property(property: 'description', description: 'A description of the file', type: 'string', nullable: true),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for uploading a product image',
    required: true,
    content: [
        new OA\MediaType(mediaType: 'multipart/form-data', schema: new Schema(ref: '#/components/schemas/ProductUploadImageInput')),
    ]
)]
class ProductUploadImageRequest extends FormRequest
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
            'image' => 'required|image|max:2048',
        ];
    }
}
