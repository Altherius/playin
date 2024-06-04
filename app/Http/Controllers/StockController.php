<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stock\StockCreateRequest;
use App\Http\Requests\Stock\StockUpdateRequest;
use App\Http\Resources\StockResource;
use App\Models\Stock;
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

    public function store(StockCreateRequest $request): StockResource
    {
        $stock = new Stock();
        $stock->retailer_id = $request->retailer_id;
        $stock->store_id = $request->store_id;
        $stock->save();

        return new StockResource($stock);
    }

    public function update(StockUpdateRequest $request, Stock $stock): StockResource
    {
        $stock->validated = $request->validated;
        $stock->sent = $request->sent;
        $stock->received = $request->received;
        $stock->save();

        return new StockResource($stock);
    }
}
