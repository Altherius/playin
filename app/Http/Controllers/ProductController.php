<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUploadImageRequest;
use App\Http\Resources\ProductResource;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    #[OA\Get(path: '/api/products', summary: 'Get collection of products', tags: ['Product'])]
    #[OA\Response(response: '200', description: 'A paginated collection of products', content: new OA\JsonContent(ref: '#/components/schemas/ProductPaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::with([
            'card_release.card_edition',
            'card_print_state',
            'boardgame_properties',
            'card_properties_magic',
            'card_properties_yugioh',
            'card_properties_fab',
            'card_properties_lorcana',
        ])->paginate());
    }

    #[OA\Post(path: '/api/products', summary: 'Create product', tags: ['Product'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/ProductCreateRequest')]
    #[OA\Response(response: '201', description: 'The created product', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Product', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function store(ProductCreateRequest $request): ProductResource
    {
        $product = new Product;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        return new ProductResource($product);
    }

    #[OA\Post(path: '/api/products/{id}/image', summary: 'Upload product image', tags: ['Product'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/ProductUploadImageRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the product', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The updated product', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Product', type: 'object'),
    ]))]
    #[OA\Response(response: '422', description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function storeImage(Product $product, ProductUploadImageRequest $request): ProductResource
    {
        $file = $request->file('image');
        $path = $file->storePublicly('public/product-images');

        $media = new Media;
        $media->file_path = $path;
        $media->description = null; // TODO: Add media description
        $media->save();

        $product->media_id = $media->id;
        $product->save();

        return new ProductResource($product->load([
            'card_release.card_edition',
            'card_print_state',
            'boardgame_properties',
            'card_properties_magic',
            'card_properties_yugioh',
            'card_properties_fab',
            'card_properties_lorcana',
        ]));
    }

    #[OA\Get(path: '/api/products/{id}', summary: 'Get product', tags: ['Product'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the product', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required product', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Product', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No product has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load([
            'card_release.card_edition',
            'card_print_state',
            'boardgame_properties',
            'card_properties_magic',
            'card_properties_yugioh',
            'card_properties_fab',
            'card_properties_lorcana',
        ]));
    }

    #[OA\Put(path: '/api/products/{id}', summary: 'Update product', tags: ['Product'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/ProductCreateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the product', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The updated product', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Product', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function update(ProductCreateRequest $request, Product $product): ProductResource
    {
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        return new ProductResource($product);
    }
}
