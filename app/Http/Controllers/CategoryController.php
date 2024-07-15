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
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(path: '/api/categories', summary: 'Get collection of categories', tags: ['Category'])]
    #[OA\Response(response: '200', description: 'A paginated collection of categories', content: new OA\JsonContent(ref: '#/components/schemas/CategoryPaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return CategoryWithHierarchyResource::collection(Category::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(path: '/api/categories', summary: 'Create category', tags: ['Category'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/CategoryCreateRequest')]
    #[OA\Response(response: '201', description: 'The created category', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Category', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
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
    #[OA\Get(path: '/api/categories/{id}', summary: 'Get category', tags: ['Category'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the category', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required category', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Category', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No category has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(Category $category): CategoryWithHierarchyResource
    {
        return new CategoryWithHierarchyResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Put(path: '/api/categories/{id}', summary: 'Update category', tags: ['Category'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/CategoryUpdateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the category', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The created category', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Category', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
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
    #[OA\Delete(path: '/api/categories/{id}', summary: 'Delete category', tags: ['Category'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the category', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '204', description: 'Category has been deleted successfully')]
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
