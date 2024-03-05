<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Stores', 'Operations related to stores')]

class StoreController extends Controller
{
    #[Endpoint("Retrieve a collection of stores")]
    #[QueryParam("page", "int", "The page number", required: false, example: 1)]
    public function index(): AnonymousResourceCollection
    {
        return StoreResource::collection(Store::paginate());
    }

    #[Endpoint("Create a store")]
    #[BodyParam("name", "string", "The name of the store.", example: "Playin Paris BNF")]
    public function store(Request $request): StoreResource
    {
        $request->validate([
            'name' => 'required',
        ]);

        $store = new Store();
        $store->name = $request->name;
        $store->save();

        return new StoreResource($store);
    }

    #[Endpoint("Retrieve a store")]
    public function show(Store $store): StoreResource
    {
        return new StoreResource($store);
    }

    #[Endpoint("Edit a store")]
    #[BodyParam("name", "string", "The name of the edited store.", example: "Playin Paris BNF")]
    public function update(Request $request, Store $store): StoreResource
    {
        $request->validate([
            'name' => 'required',
        ]);

        $store->name = $request->name;
        $store->save();

        return new StoreResource($store);
    }
}
