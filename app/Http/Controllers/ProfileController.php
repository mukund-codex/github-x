<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $request->validated();
        $update = $request->safe();
        if (isset($update['password'])) {
            $update['password'] = Hash::make($update['password']);
        }
        $user = Auth::user();
        $user->update($update->toArray());

        return (new UserResource($user))
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
