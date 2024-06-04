<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::with([
            'card_release.card_edition',
            'card_print_state',
            'boardgame_properties',
            'card_properties_magic',
            'card_properties_yugioh',
            'card_properties_fab',
            'card_properties_lorcana',
        ])->paginate());
    }

    public function store(ProductCreateRequest $request): ProductResource
    {
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        return new ProductResource($product);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load([
            'card_release.card_edition',
            'card_print_state',
            'boardgame_properties',
            'card_properties_magic',
            'card_properties_yugioh',
            'card_properties_fab',
            'card_properties_lorcana',
        ]));
    }

    public function update(ProductCreateRequest $request, Product $product): ProductResource
    {
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        return new ProductResource($product);
    }
}
