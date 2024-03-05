<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoreController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return StoreResource::collection(Store::paginate());
    }

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

    public function show(Store $store): StoreResource
    {
        return new StoreResource($store);
    }

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
