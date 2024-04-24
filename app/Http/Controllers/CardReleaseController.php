<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardReleaseResource;
use App\Models\CardRelease;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CardReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return CardReleaseResource::collection(CardRelease::paginate());
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
