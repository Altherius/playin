<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return OrderResource::collection(Order::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Order $order): OrderResource
    {
        return new OrderResource($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order): OrderResource
    {
        $request->validate([
            'validated' => 'required',
        ]);

        $order->validated = $request->validated;
        $order->save();

        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
