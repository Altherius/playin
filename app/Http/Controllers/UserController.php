<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Get(path: '/api/users', summary: 'Get collection of users', tags: ['User'])]
    #[OA\Response(response: '200', description: 'A paginated collection of users', content: new OA\JsonContent(ref: '#/components/schemas/UserPaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::paginate());
    }

    #[OA\Get(path: '/api/users/{id}', summary: 'Get user', tags: ['User'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the user', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required user', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/User', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No user has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    #[OA\Get(path: '/api/users/me', summary: 'Get currently logged in user', tags: ['User'])]
    #[OA\Response(response: '200', description: 'The currently logged in user', content: new OA\JsonContent(ref: '#/components/schemas/User'))]
    #[OA\Response(response: '401', description: 'User is not logged in', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function me(): UserResource
    {
        return new UserResource(Auth::user());
    }
}
