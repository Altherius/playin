<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderCreateRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return OrderResource::collection(Order::paginate());
    }

    public function store(OrderCreateRequest $request): OrderResource
    {
        $order = new Order();
        $order->customer_id = $request->customer_id;
        $order->store_id = $request->store_id;
        $order->save();

        return new OrderResource($order);
    }

    public function show(Order $order): OrderResource
    {
        return new OrderResource($order);
    }

    public function update(OrderUpdateRequest $request, Order $order): OrderResource
    {
        $order->validated = $request->validated;
        $order->sent = $request->sent;
        $order->received = $request->received;
        $order->save();

        return new OrderResource($order);
    }
}
