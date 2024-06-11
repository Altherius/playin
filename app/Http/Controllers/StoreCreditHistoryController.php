<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreCreditHistoryResource;
use App\Models\StoreCreditHistory;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoreCreditHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return StoreCreditHistoryResource::collection(StoreCreditHistory::paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(StoreCreditHistory $storeCreditHistory): StoreCreditHistoryResource
    {
        return new StoreCreditHistoryResource($storeCreditHistory);
    }

    public function forUser(User $user): AnonymousResourceCollection
    {
        return StoreCreditHistoryResource::collection($user->store_credit_history);
    }
}
