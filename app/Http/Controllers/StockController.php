<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockResource;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Stocks', 'Operations related to stocks and their items')]

class StockController extends Controller
{
    #[Endpoint('Retrieve a collection of stocks')]
    #[QueryParam('page', 'int', 'The page number', required: false, example: 1)]
    public function index(): AnonymousResourceCollection
    {
        return StockResource::collection(Stock::paginate());
    }

    #[Endpoint('Retrieve a stock')]
    public function show(Stock $stock): StockResource
    {
        return new StockResource($stock);
    }

    #[Endpoint('Create a stock')]
    #[BodyParam('retailer_id', 'int', 'The id of the user who is the retailer of the stock.', example: 1)]
    #[BodyParam('store_id', 'int', 'The id of the store related to the stock.', example: 1)]
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

    #[Endpoint('Edit a stock')]
    #[BodyParam('validated', 'bool', 'true if the stock is validated and the products must be added to local stock, false otherwise.')]
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
