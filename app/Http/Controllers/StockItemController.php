<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockResource;
use App\Models\StockItem;
use Illuminate\Http\Request;

class StockItemController extends Controller
{
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
