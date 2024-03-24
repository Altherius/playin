<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Orders', 'Operations related to orders and their items')]
class OrderController extends Controller
{
    #[Endpoint('Retrieve a collection of orders')]
    #[QueryParam('page', 'int', 'The page number', required: false, example: 1)]
    public function index(): AnonymousResourceCollection
    {
        return OrderResource::collection(Order::paginate());
    }

    #[Endpoint('Create an order')]
    #[BodyParam('customer_id', 'int', 'The id of the user who is the customer of the order.', example: 1)]
    #[BodyParam('store_id', 'int', 'The id of the store related to the order.', example: 1)]
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

    #[Endpoint('Retrieve an order')]
    public function show(Order $order): OrderResource
    {
        return new OrderResource($order);
    }

    #[Endpoint('Edit an order')]
    #[BodyParam('validated', 'bool', 'true if the stock is validated and the products must be deduced from local stock, false otherwise.')]
    #[BodyParam('sent', 'bool', 'true if the stock is sent, false otherwise.')]
    #[BodyParam('sent', 'bool', 'true if the stock is received, false otherwise.')]
    public function update(Request $request, Order $order): OrderResource
    {
        $request->validate([
            'validated' => 'required|boolean|accepted_if:sent,true',
            'sent' => 'required|boolean|accepted_if:received,true',
            'received' => 'required|boolean',
        ]);

        $order->validated = $request->validated;
        $order->sent = $request->sent;
        $order->received = $request->received;
        $order->save();

        return new OrderResource($order);
    }
}
