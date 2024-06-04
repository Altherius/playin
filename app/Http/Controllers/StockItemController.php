<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockItem\StockItemCreateRequest;
use App\Http\Resources\StockResource;
use App\Models\StockItem;

class StockItemController extends Controller
{
    public function store(StockItemCreateRequest $request): StockResource
    {
        $item = new StockItem();

        $item->stock_id = $request->stock_id;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->unit_price;

        $item->save();

        return new StockResource($item->stock);
    }

    public function update(StockItemCreateRequest $request, StockItem $item): StockResource
    {
        $item->stock_id = $request->stock_id;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->unit_price;

        $item->save();

        return new StockResource($item->stock);
    }
}
