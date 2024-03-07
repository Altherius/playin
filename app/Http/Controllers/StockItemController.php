<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockResource;
use App\Models\StockItem;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;

#[Group('Stocks', 'Operations related to stocks and their items')]

class StockItemController extends Controller
{
    #[Endpoint('Add an item to a stock')]
    #[BodyParam('stock_id', 'int', 'The id of the related stock.', example: 1)]
    #[BodyParam('product_id', 'int', 'The id of the related product.', example: 1)]
    #[BodyParam('quantity', 'int', 'The quantity of the product ordered.', example: 4)]
    #[BodyParam('unit_price', 'number', 'The unit price of the product in the order.', example: 19.9)]
    public function store(Request $request): StockResource
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'gte:1',
            'unit_price' => 'required|min:0',
        ]);

        $item = new StockItem();

        $item->stock_id = $request->stock_id;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->unit_price;

        $item->save();

        return new StockResource($item->stock);
    }

    #[Endpoint('Edit an item of a stock')]
    #[BodyParam('stock_id', 'int', 'The id of the related stock.', example: 1)]
    #[BodyParam('product_id', 'int', 'The id of the related product.', example: 1)]
    #[BodyParam('quantity', 'int', 'The quantity of the product ordered.', example: 4)]
    #[BodyParam('unit_price', 'number', 'The unit price of the product in the order.', example: 19.9)]
    public function update(Request $request, StockItem $item): StockResource
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'gte:1',
            'unit_price' => 'required|min:0',
        ]);

        $item->stock_id = $request->stock_id;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->unit_price;

        $item->save();

        return new StockResource($item->stock);
    }
}
