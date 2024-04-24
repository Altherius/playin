<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Products', 'Operations related to products')]
class ProductController extends Controller
{
    #[Endpoint('Retrieve a collection of products')]
    #[QueryParam('page', 'int', 'The page number', required: false, example: 1)]
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

    #[Endpoint('Create a product')]
    #[BodyParam('name', 'string', 'The name of the product.', example: 'Wingspan')]
    #[BodyParam('price', 'number', 'The default price of the product.', example: 19.9)]
    public function store(Request $request): ProductResource
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|gte:0',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        return new ProductResource($product);
    }

    #[Endpoint('Retrieve a product')]
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

    #[Endpoint('Edit a product')]
    #[BodyParam('name', 'string', 'The name of the product.', example: 'Wingspan')]
    #[BodyParam('price', 'number', 'The default price of the product.', example: 19.9)]
    public function update(Request $request, Product $product): ProductResource
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|gte:0',
        ]);

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        return new ProductResource($product);
    }
}
