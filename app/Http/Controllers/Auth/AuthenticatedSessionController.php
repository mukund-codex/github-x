<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $token = Auth::user()->createToken(request()->userAgent())->plainTextToken;

        return response()->json(['data' => ['token' => $token]]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        $token = $request->user()->tokens()->where(
            'id',
            Str::before($request->bearerToken(), '|')
        )->first();
        $token->expires_at = now();
        $token->save();
        return response()->json(['data' => ['token' => '']]);
    }
}
