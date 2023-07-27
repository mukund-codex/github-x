<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Config;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use URL;

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
        $user->assignRole(Config::get('constants.roles.user'));

        event(new Registered($user));

        $response = $this->response($user->toArray(), __('messages.user.registered'), 201);
        if (in_array(app()->environment(), ['testing', 'local'])) {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addHour(),
                ['id' => $user->id, 'hash' => sha1($user->email), 'no-redirect' => true],
            );
            $response->withCookie(new Cookie('verification_url', $verificationUrl));
        }
        return $response;
    }
}
