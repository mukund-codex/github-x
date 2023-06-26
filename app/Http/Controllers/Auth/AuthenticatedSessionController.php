<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Str;

class AuthenticatedSessionController extends Controller
{
    use HttpResponse;

    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $token = Auth::user()->createToken(request()->userAgent())->plainTextToken;

        return $this->response(
            array_merge(Auth::user()->toArray(), ['token' => $token]),
            __('messages.user.logged_in')
        );
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
        return $this->response(['token' => ''], __('messages.user.logged_out'));
    }
}
