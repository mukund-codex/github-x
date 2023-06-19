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

        return (new UserResource($user))
            ->additional(['message' => __('messages.user.registered')])
            ->response()
            ->setStatusCode(201);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $request->validated();
        $update = $request->safe();
        if (isset($update['password'])) {
            $update['password'] = Hash::make($update['password']);
        }
        $user->update($update->except('role'));
        if (isset($update['role'])) {
            $user->syncRoles([$update['role']]);
        }

        return (new UserResource($user))
            ->additional(['message' => __('messages.user.updated')])
            ->response();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->response([], __('messages.user.deleted'));
    }

}
