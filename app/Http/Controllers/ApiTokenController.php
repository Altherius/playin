<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\TokenRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiTokenController extends Controller
{
    /**
     * @throws ValidationException In case of invalid credentials.
     */
    public function token(TokenRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            $exception = ValidationException::withMessages([
                'password' => ['The provided credentials are incorrect.'],
            ]);

            $exception->status = 401;

            throw $exception;
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
