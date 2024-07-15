<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardReleaseResource;
use App\Models\CardRelease;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class CardReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(path: '/api/card-releases', summary: 'Get collection of card releases', tags: ['Card Release'])]
    #[OA\Response(response: '200', description: 'A paginated collection of card releases', content: new OA\JsonContent(ref: '#/components/schemas/CardReleasePaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return CardReleaseResource::collection(CardRelease::with('products')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(path: '/api/card-releases/{id}', summary: 'Get card release', tags: ['Card Release'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the card release', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required card release', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/CardRelease', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No card release has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(CardRelease $cardRelease): CardReleaseResource
    {
        return new CardReleaseResource($cardRelease);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CardRelease $cardRelease)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CardRelease $cardRelease)
    {
        //
    }
}
