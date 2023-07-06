<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testSuperAdminCanSeeProfile()
    {
        $admin = (User::factory()->create())->assignRole(config('const.roles.super_admin'));
        $this->actingAs($admin)
            ->get(route('admin.profile.edit'))
            ->assertOk();
    }

    public function testUserCannotSeeProfile()
    {
        $user = (User::factory()->create())->assignRole(config('const.roles.user'));
        $this->actingAs($user)
            ->get(route('admin.profile.edit'))
            ->assertForbidden();
    }

    public function testSuperAdminCanUpdateProfile()
    {
        $admin = (User::factory()->create())->assignRole(config('const.roles.super_admin'));
        $this->actingAs($admin)
            ->patch(route('admin.profile.update'), [
                'first_name' => 'test_first_name',
                'last_name' => 'test_last_name'
            ]);
        $this->assertTrue($admin->first_name === 'test_first_name');
        $this->assertTrue($admin->last_name === 'test_last_name');
    }

    public function testUserCannotUpdateProfile()
    {
        $user = (User::factory()->create())->assignRole(config('const.roles.user'));
        $this->actingAs($user)
            ->patch(route('admin.profile.update'), [
                'first_name' => 'test123'
            ])
            ->assertForbidden();
        $this->assertFalse($user->first_name === 'test123');
    }

    public function testSuperAdminCanUpdateProfileEmail()
    {
        $admin = (User::factory()->create())->assignRole(config('const.roles.super_admin'));
        $this->actingAs($admin)
            ->patch(route('admin.profile.update'), [
                'email' => 'test@example.com',
            ]);
        $this->assertNull($admin->email_verified_at);
        $this->assertTrue($admin->email === 'test@example.com');
        $this->assertFalse($this->isAuthenticated());
    }

    public function testSuperAdminCanUpdateProfilePassword()
    {
        $admin = (User::factory()->create())->assignRole(config('const.roles.super_admin'));
        $admin->update([
            'password' => Hash::make('Password@123'),
        ]);

        $response = $this->actingAs($admin)
            ->put(route('admin.password.update'), [
                'current_password' => 'Password@123',
                'password' => 'Password@1234',
                'password_confirmation' => 'Password@1234'
            ]);
        $response->assertValid(['current_password', 'password'], 'updatePassword');
    }

    public function testSuperAdminCannotUpdateProfilePasswordIfNotMatch()
    {
        $admin = (User::factory()->create())->assignRole(config('const.roles.super_admin'));
        $admin->update([
            'password' => Hash::make('Password@123'),
        ]);

        $this->actingAs($admin)
            ->put(route('admin.password.update'), [
                'current_password' => 'Password@123',
                'password' => 'Password@1234',
                'password_confirmation' => 'Password@12345'
            ])
            ->assertInvalid(['password'], 'updatePassword');
    }

    public function testSuperAdminCannotUpdateProfilePasswordIfNotPassRequirements()
    {
        $admin = (User::factory()->create())->assignRole(config('const.roles.super_admin'));
        $admin->update([
            'password' => Hash::make('Password@123'),
        ]);

        $this->actingAs($admin)
            ->put(route('admin.password.update'), [
                'current_password' => 'Password@123',
                'password' => 'password',
                'password_confirmation' => 'password'
            ])
            ->assertInvalid(['password'], 'updatePassword');
    }

    public function testSuperAdminCannotUpdateProfilePasswordIfCurrentPasswordIsIncorrect()
    {
        $admin = (User::factory()->create())->assignRole(config('const.roles.super_admin'));

        $this->actingAs($admin)
            ->put(route('admin.password.update'), [
                'current_password' => 'Password@123',
                'password' => 'Password@123123',
                'password_confirmation' => 'Password@123123'
            ])
            ->assertInvalid(['current_password'], 'updatePassword');
    }
}
