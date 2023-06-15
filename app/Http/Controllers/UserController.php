<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponse;
use Config;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HttpResponse;

    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    public function store(RegisterUserRequest $request): JsonResponse
    {
        $request->validated();
        $user_info = $request->safe();
        $user = resolve(User::class)->create(
            [
                'first_name' => $user_info['first_name'],
                'last_name' => $user_info['last_name'] ?? null,
                'email' => $user_info['email'],
                'password' => Hash::make($user_info['password']),
            ]
        );
        $role = $user_info['role'] ?? Config::get('const.roles.user');
        $user->assignRole($role);

        event(new Registered($user));

        return $this->response($user->toArray(), __('messages.user.registered'), 201);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
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
        $user->update($update);
        if (isset($user_info['role'])) {
            $user->syncRoles([$user_info['role']]);
        }

        return $this->response($user->toArray(), __('messages.user.updated'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->response([], __('messages.user.deleted'));
    }

}
