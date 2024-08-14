<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{
    /**
     * Handle user login.
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate(); // Authenticate using the custom LoginRequest

        $user = Auth::user();

        // Generate a new Passport token
        $token = $user->createToken('apiUserToken')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'User logged in successfully',
        ], 200);
    }

    /**
     * Handle user logout.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        // Revoke the current user's token
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out.'], 200);
    }
}