<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Pest\Expectation;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

use function Pest\Laravel\assertAuthenticated;
use function PHPUnit\Framework\assertEquals;

uses(TestCase::class, RefreshDatabase::class)->in('Feature', 'Unit');

expect()->extend(
    'toBeAuthenticated',
    function (string $guard = null): Expectation {
        assertAuthenticated($guard);
        $authenticated = Auth::guard($guard)->user();

        assertEquals(
            $this->value->id,
            $authenticated->id,
            "The User ID #{$this->value->id} doesn't match authenticated User ID #{$authenticated->id}"
        );

        return $this;
    }
);

function createRawUser(string $email = '', string $password = ''): User
{
    return User::factory()->create([
        'email' => $email ?: fake()->email,
        'password' => Hash::make($password) ?: Hash::make(fake()->password()),
    ]);
}

function createUser(string $email = '', string $password = ''): User
{
    $user_role = config('const.roles.user');
    return createRawUser($email, $password)->assignRole($user_role);
}

function createSuperAdmin(string $email = '', string $password = ''): User
{
    $super_admin_role = config('const.roles.super_admin');
    return createRawUser($email, $password)->assignRole($super_admin_role);
}

function getRoleUser(): Role
{
    return Role::where('name', config('const.roles.user'))->first();
}
