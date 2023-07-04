<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request, ?User $user): JsonResponse|RedirectResponse
    {
        $user = $user ?? $request->user();
        if ($user->hasVerifiedEmail()) {
            return response()->json(
                ['status' => 'user-is-already-verified'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);
    }
}
