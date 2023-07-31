<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetLinkRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function store(PasswordResetLinkRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            activity()
                ->causedByAnonymous()
                ->withProperties([
                    'message' => __($status),
                    'email' => $request->email
                ])
                ->log('Password reset fail');
        }

        return response()->json(['status' => __('passwords.sent')]);
    }
}
