<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function store(Request $request): OrderResource
    {
        $request->validate([
            'order_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'gte:1',
            'unit_price' => 'required|min:0',
        ]);

        $item = new OrderItem();

        $item->order_id = $request->order_id;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->unit_price;

        $item->save();

        return new OrderResource($item->order);
    }

    public function update(Request $request, OrderItem $item): OrderResource
    {
        $request->validate([
            'order_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'gte:1',
            'unit_price' => 'required|min:0',
        ]);

        $item->order_id = $request->order_id;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->unit_price;

        $item->save();

        return new OrderResource($item->order);
    }
}
