<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\CategoryWithHierarchyResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return CategoryWithHierarchyResource::collection(Category::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request): JsonResponse
    {
        $category = new Category();

        $category->name = $request->name;
        $category->category_id = $request->category_id;

        $category->save();

        return (new CategoryWithHierarchyResource($category))->response()->setStatusCode(201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): CategoryWithHierarchyResource
    {
        return new CategoryWithHierarchyResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category): CategoryWithHierarchyResource
    {
        $category->name = $request->name;
        $category->category_id = $request->category_id;

        $category->save();

        return new CategoryWithHierarchyResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }

    public function products(Category $category): AnonymousResourceCollection
    {
        $categoriesId = [$category->id];
        array_walk_recursive($category->children, function ($element) use (&$categoriesId) {
            if ($element instanceof Category) {
                $categoriesId[] = $element->id;
            }
        });
        $categoriesId = array_unique($categoriesId);

        return ProductResource::collection(Product::whereIn('category_id', $categoriesId)
            ->paginate()
        );
    }
}
