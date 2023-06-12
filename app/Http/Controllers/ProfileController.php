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
        return new UserResource(Auth::user());
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $request->validated();
        $user_info = $request->safe();
        $update = [
            'first_name' => $user_info['first_name'],
            'last_name' => $user_info['last_name'] ?? null,
        ];
        if (isset($user_info['password'])) {
            $update['password'] = Hash::make($user_info['password']);
        }
        $user = Auth::user();
        $user->update($update);

        return $this->response($user->toArray(), __('messages.profile.updated'));
    }

    public function destroy(): JsonResponse
    {
        $user = Auth::user();
        $user->delete();
        return $this->response([], __('messages.profile.deleted'));
    }

}
