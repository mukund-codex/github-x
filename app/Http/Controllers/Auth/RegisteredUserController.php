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
        $userInfo = $request->safe();
        $user = resolve(User::class)->create(
            [
                'first_name' => $userInfo['first_name'],
                'last_name' => $userInfo['last_name'] ?? null,
                'email' => $userInfo['email'],
                'password' => Hash::make($userInfo['password']),
            ]
        );
        $user->assignRole(Config::get('const.roles.user'));

        event(new Registered($user));

        return $this->response($user->toArray(), __('messages.user.registered'), 201);
    }
}
