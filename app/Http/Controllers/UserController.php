<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Users', 'Operations related to users')]
class UserController extends Controller
{
    #[Endpoint("Retrieve a collection of users")]
    #[QueryParam("page", "int", "The page number", required: false, example: 1)]
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::paginate());
    }

    #[Endpoint("Retrieve a user")]
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    #[Endpoint("Retrieve currently logged in user")]
    public function me(): UserResource
    {
        return new UserResource(Auth::user());
    }
}
