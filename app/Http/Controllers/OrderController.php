<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderCreateRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class OrderController extends Controller
{
    #[OA\Get(path: '/api/orders', summary: 'Get collection of orders', tags: ['Order'])]
    #[OA\Response(response: '200', description: 'A paginated collection of orders', content: new OA\JsonContent(ref: '#/components/schemas/OrderPaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return OrderResource::collection(Order::paginate());
    }

    #[OA\Post(path: '/api/orders', summary: 'Create order', tags: ['Order'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/OrderCreateRequest')]
    #[OA\Response(response: '201', description: 'The created order', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Order', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function store(OrderCreateRequest $request): OrderResource
    {
        $order = new Order;
        $order->customer_id = $request->customer_id;
        $order->store_id = $request->store_id;
        $order->save();

        return new OrderResource($order);
    }

    #[OA\Get(path: '/api/orders/{id}', summary: 'Get order', tags: ['Order'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the order', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required order', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Order', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No order has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(Order $order): OrderResource
    {
        return new OrderResource($order);
    }

    #[OA\Put(path: '/api/orders/{id}', summary: 'Update order', tags: ['Order'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/OrderUpdateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the order', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The updated order', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Order', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function update(OrderUpdateRequest $request, Order $order): OrderResource
    {
        $order->validated = $request->validated;
        $order->sent = $request->sent;
        $order->received = $request->received;
        $order->payment_status = $request->payment_status;
        $order->payment_mode = $request->payment_mode;
        $order->save();

        return new OrderResource($order);
    }
}
