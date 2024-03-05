<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;

#[Group('Orders', 'Operations related to orders and their items')]
class OrderItemController extends Controller
{
    #[Endpoint("Add an item to an order")]
    #[BodyParam("order_id", "int", "The id of the related order.", example: 1)]
    #[BodyParam("product_id", "int", "The id of the related product.", example: 1)]
    #[BodyParam("quantity", "int", "The quantity of the product ordered.", example: 4)]
    #[BodyParam("unit_price", "number", "The unit price of the product in the order.", example: 19.9)]
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

    #[Endpoint("Edit an item of an order")]
    #[BodyParam("order_id", "int", "The id of the related order.", example: 1)]
    #[BodyParam("product_id", "int", "The id of the related product.", example: 1)]
    #[BodyParam("quantity", "int", "The quantity of the product ordered.", example: 4)]
    #[BodyParam("unit_price", "number", "The unit price of the product in the order.", example: 19.9)]
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
