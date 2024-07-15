<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockItem\StockItemCreateRequest;
use App\Http\Resources\StockResource;
use App\Models\StockItem;
use OpenApi\Attributes as OA;

class StockItemController extends Controller
{
    #[OA\Post(path: '/api/stock-items', summary: 'Create stock item', tags: ['Stock Item'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/StockItemCreateRequest')]
    #[OA\Response(response: '201', description: 'The created stock item', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/StockItem', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function store(StockItemCreateRequest $request): StockResource
    {
        $item = new StockItem();

        $item->stock_id = $request->stock_id;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->unit_price;

        $item->save();

        return new StockResource($item->stock);
    }

    #[OA\Put(path: '/api/stock-items/{id}', summary: 'Update stock item', tags: ['Stock Item'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/StockItemCreateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the stock item', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The updated stock item', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/StockItem', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function update(StockItemCreateRequest $request, StockItem $item): StockResource
    {
        $item->stock_id = $request->stock_id;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->unit_price;

        $item->save();

        return new StockResource($item->stock);
    }
}
