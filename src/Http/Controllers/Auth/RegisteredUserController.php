<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class RegisteredUserController extends Controller
{
    /**
     * Handle user registration.
     *
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        // Validate the request data
        $validated = $request->validated();

        // Create a new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        // Automatically log in the user after registration
        Auth::login($user);

        // Generate a new Passport token
        $token = $user->createToken('apiUserToken')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 201);
    }
}
