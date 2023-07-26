<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class AuthenticatedSessionController extends Controller
{
    use HttpResponse;

    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();
        $user = Auth::user();
        if (!$user->hasVerifiedEmail()) {
            Auth::logout();
            return $this->response(
                message: __('auth.email_verification'),
                httpCode: 403
            );
        }
        $token = $user->createToken(request()->userAgent())->plainTextToken;
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->log('Log in');

        return $this->response(
            array_merge(Auth::user()->toArray(), ['token' => $token]),
            __('messages.user.logged_in')
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();
        $token = $user->tokens()->where(
            'id',
            Str::before($request->bearerToken(), '|')
        )->first();
        $token->expires_at = now();
        $token->save();
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->log('Log out');
        return $this->response(['token' => ''], __('messages.user.logged_out'));
    }
}
