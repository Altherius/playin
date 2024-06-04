<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItem\OrderItemCreateRequest;
use App\Http\Resources\OrderResource;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
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
