<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GetAuthUserController extends Controller
{
    /**
     * Display the authenticated user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        // Get the authenticated user and Return user data as a JSON response
        return response()->json($request->user());
    }
}
