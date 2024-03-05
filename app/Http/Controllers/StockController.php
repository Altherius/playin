<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockResource;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StockController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return StockResource::collection(Stock::paginate());
    }

    public function show(Stock $stock): StockResource
    {
        return new StockResource($stock);
    }

    public function store(Request $request): StockResource
    {
        $request->validate([
            'retailer_id' => 'required|exists:users,id',
            'store_id' => 'required|exists:stores,id',
        ]);

        $stock = new Stock();
        $stock->retailer_id = $request->retailer_id;
        $stock->store_id = $request->store_id;
        $stock->save();

        return new StockResource($stock);
    }

    public function update(Request $request, Stock $stock): StockResource
    {
        $request->validate([
            'validated' => 'required',
        ]);

        $stock->validated = $request->validated;
        $stock->save();

        return new StockResource($stock);
    }
}
