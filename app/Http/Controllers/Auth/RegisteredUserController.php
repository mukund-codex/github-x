<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Config;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    use HttpResponse;

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
        $user->assignRole(Config::get('const.roles.user'));

        event(new Registered($user));

        return $this->response($user->toArray(), __('messages.user.registered'), 201);
    }
}
