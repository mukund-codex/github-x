<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function testSuperAdminCanSeeRoleTable()
    {
        $admin = (User::factory()->create())->assignRole(config('const.roles.super_admin'));
        $this->actingAs($admin)
            ->get(route('admin.roles.index'))
            ->assertOk();
    }

    public function testUserCannotSeeRoleTable()
    {
        $user = (User::factory()->create())->assignRole(config('const.roles.user'));
        $this->actingAs($user)
            ->get(route('admin.roles.index'))
            ->assertForbidden();
    }

    public function testUserWithPermissionsCanSeeRoleTable()
    {
        $user = (User::factory()->create())->assignRole(config('const.roles.user'));
        $user->givePermissionTo('view dashboard', 'view roles');
        $this->actingAs($user)
            ->get(route('admin.roles.index'))
            ->assertOk();
    }
}
