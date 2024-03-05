<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return OrderResource::collection(Order::paginate());
    }

    public function store(Request $request): OrderResource
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'store_id' => 'required|exists:stores,id',
        ]);

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

    public function edit(Order $order)
    {

    }

    public function update(Request $request, Order $order): OrderResource
    {
        $request->validate([
            'validated' => 'required',
        ]);

        $order->validated = $request->validated;
        $order->save();

        return new OrderResource($order);
    }
}
