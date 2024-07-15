<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreCreditHistoryResource;
use App\Models\StoreCreditHistory;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class StoreCreditHistoryController extends Controller
{
    #[OA\Get(path: '/api/store-credit-histories', summary: 'Get collection of stock credit history entries', tags: ['Store Credit History'])]
    #[OA\Response(response: '200', description: 'A paginated collection of store credit history entries', content: new OA\JsonContent(ref: '#/components/schemas/StoreCreditHistoryPaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return StoreCreditHistoryResource::collection(StoreCreditHistory::paginate());
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(path: '/api/stores-credit-histories/{id}', summary: 'Get store credit history entry', tags: ['Store Credit History'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the entry', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required entry', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/StoreCreditHistory', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No entry has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(StoreCreditHistory $storeCreditHistory): StoreCreditHistoryResource
    {
        return new StoreCreditHistoryResource($storeCreditHistory);
    }

    #[OA\Get(path: '/api/users/{user}/store-credit-history', summary: 'Get user store credit history', tags: ['Store Credit History'])]
    #[OA\Parameter(name: 'user', description: 'The ID of the target user', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'A paginated collection of store credit history entries for the given user', content: new OA\JsonContent(ref: '#/components/schemas/StoreCreditHistoryPaginatedCollection'))]
    public function forUser(User $user): AnonymousResourceCollection
    {
        return StoreCreditHistoryResource::collection($user->store_credit_history);
    }
}
