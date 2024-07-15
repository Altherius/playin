<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItem\OrderItemCreateRequest;
use App\Http\Resources\OrderResource;
use App\Models\OrderItem;
use OpenApi\Attributes as OA;

class OrderItemController extends Controller
{
    #[OA\Post(path: '/api/order-items', summary: 'Create order item', tags: ['Order Item'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/OrderItemCreateRequest')]
    #[OA\Response(response: '201', description: 'The created order item', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/OrderItem', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function store(OrderItemCreateRequest $request): OrderResource
    {
        $item = new OrderItem();

        $item->order_id = $request->order_id;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->unit_price;

        $item->save();

        return new OrderResource($item->order);
    }

    #[OA\Put(path: '/api/order-items/{id}', summary: 'Update order item', tags: ['Order Item'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/OrderItemCreateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the order item', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The updated order item', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/OrderItem', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function update(OrderItemCreateRequest $request, OrderItem $item): OrderResource
    {
        $item->order_id = $request->order_id;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->unit_price;

        $item->save();

        return new OrderResource($item->order);
    }
}
