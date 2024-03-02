<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockResource;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return StockResource::collection(Stock::paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock): StockResource
    {
        return new StockResource($stock);
    }

    public function store(Request $request): StockResource
    {
        $request->validate([
            'retailer_id' => 'required|exists:users,id',
        ]);

        $stock = new Stock();
        $stock->retailer_id = $request->retailer_id;
        $stock->save();

        return new StockResource($stock);
    }
}
