<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreCreateRequest;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoreController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return StoreResource::collection(Store::paginate());
    }

    public function store(StoreCreateRequest $request): StoreResource
    {
        $store = new Store();
        $store->name = $request->name;
        $store->save();

        return new StoreResource($store);
    }

    public function show(Store $store): StoreResource
    {
        return new StoreResource($store);
    }

    public function update(StoreCreateRequest $request, Store $store): StoreResource
    {
        $store->name = $request->name;
        $store->save();

        return new StoreResource($store);
    }
}
