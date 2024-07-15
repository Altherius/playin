<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stock\StockCreateRequest;
use App\Http\Requests\Stock\StockUpdateRequest;
use App\Http\Resources\StockResource;
use App\Models\Stock;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class StockController extends Controller
{
    #[OA\Get(path: '/api/stocks', summary: 'Get collection of stocks', tags: ['Stock'])]
    #[OA\Response(response: '200', description: 'A paginated collection of orders', content: new OA\JsonContent(ref: '#/components/schemas/StockPaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return StockResource::collection(Stock::paginate());
    }

    #[OA\Get(path: '/api/stocks/{id}', summary: 'Get stock', tags: ['Stock'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the stock', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required stock', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Stock', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No stock has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(Stock $stock): StockResource
    {
        return new StockResource($stock);
    }

    #[OA\Post(path: '/api/stocks', summary: 'Create stock', tags: ['Stock'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/StockCreateRequest')]
    #[OA\Response(response: '201', description: 'The created stock', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Stock', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function store(StockCreateRequest $request): StockResource
    {
        $stock = new Stock();
        $stock->retailer_id = $request->retailer_id;
        $stock->store_id = $request->store_id;
        $stock->save();

        return new StockResource($stock);
    }

    #[OA\Put(path: '/api/stocks/{id}', summary: 'Update stock', tags: ['Stock'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/StockUpdateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the stock', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The updated stock', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Stock', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function update(StockUpdateRequest $request, Stock $stock): StockResource
    {
        $stock->validated = $request->validated;
        $stock->sent = $request->sent;
        $stock->received = $request->received;
        $stock->save();

        return new StockResource($stock);
    }
}
