<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use HttpResponse;

    public function show(): UserResource
    {
        $user = Auth::user();
        return (new UserResource($user))->additional([
            'additional_data' => [
                'billing_portal_url' => $user->hasStripeId() ? $user->billingPortalUrl() : null
            ]
        ]);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return (new UserResource($request->user()))
            ->additional(['message' => __('messages.profile.updated')])
            ->response();
    }

    public function destroy(): JsonResponse
    {
        $user = Auth::user();
        $user->delete();
        return $this->response([], __('messages.profile.deleted'));
    }

}
