<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreCreateRequest;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class StoreController extends Controller
{
    #[OA\Get(path: '/api/stores', summary: 'Get collection of stores', tags: ['Store'])]
    #[OA\Response(response: '200', description: 'A paginated collection of stores', content: new OA\JsonContent(ref: '#/components/schemas/StorePaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return StoreResource::collection(Store::paginate());
    }

    #[OA\Post(path: '/api/stores', summary: 'Create store', tags: ['Store'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/StoreCreateRequest')]
    #[OA\Response(response: '201', description: 'The created store', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Store', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function store(StoreCreateRequest $request): StoreResource
    {
        $store = new Store();
        $store->name = $request->name;
        $store->save();

        return new StoreResource($store);
    }

    #[OA\Get(path: '/api/stores/{id}', summary: 'Get store', tags: ['Store'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the store', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required store', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Store', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No store has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(Store $store): StoreResource
    {
        return new StoreResource($store);
    }

    #[OA\Put(path: '/api/stores/{id}', summary: 'Update store', tags: ['Store'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/StoreCreateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the store', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The created store', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Store', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function update(StoreCreateRequest $request, Store $store): StoreResource
    {
        $store->name = $request->name;
        $store->save();

        return new StoreResource($store);
    }
}
