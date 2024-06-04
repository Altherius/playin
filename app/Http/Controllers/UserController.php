<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::paginate());
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function me(): UserResource
    {
        return new UserResource(Auth::user());
    }
}
