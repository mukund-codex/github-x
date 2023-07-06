<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function testSuperAdminCanSeeDashboard()
    {
        $admin = (User::factory()->create())->assignRole(config('const.roles.super_admin'));
        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function testUserWithoutPermissionCannotSeeDashboard()
    {
        $user = (User::factory()->create())->assignRole(config('const.roles.user'));
        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function testUserWithPermissionCanSeeDashboard()
    {
        $user = (User::factory()->create())->assignRole(config('const.roles.user'));
        $user->givePermissionTo('view dashboard');
        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function testUserWithRolePermissionCanSeeDashboard()
    {
        $user = (User::factory()->create())->assignRole(config('const.roles.user'));
        Role::where('name', config('const.roles.user'))->first()
            ->givePermissionTo('view dashboard');

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }
}
