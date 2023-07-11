<?php

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

test('Reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('Password can be reset with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function (object $notification) use ($user) {
        Event::fake();
        $response = $this->post(route('password.store'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
        ]);
        Event::assertDispatched(PasswordReset::class);
        $response->assertSessionHasNoErrors();

        return true;
    });
});

test('Password cannot be reset with wrong email', function () {
    Notification::fake();
    $this->post(route('password.email'), ['email' => 'wrong-email@example.com'])
        ->assertSessionHasErrors();
    Notification::assertNothingSent();
});
