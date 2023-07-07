<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function testSuperAdminCanSeeUsers()
    {
        $admin = (User::factory()
            ->create())->assignRole(config('const.roles.super_admin'));
        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk();
    }

    public function testUserWithPermissionsCanSeeUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $user->givePermissionTo('view dashboard', 'view users');
        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertOk();
    }

    public function testUserWithoutPermissionsCannotSeeUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function testUserWithRoleWithPermissionsCanSeeUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.super_admin'));
        Role::where('name', config('const.roles.user'))->first()
            ->givePermissionTo('view dashboard', 'view users');
        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertOk();
    }

    public function testSuperAdminCanDeleteUsers()
    {
        $admin = (User::factory()
            ->create())->assignRole(config('const.roles.super_admin'));
        $test_user = User::factory()->create();
        $id = $test_user->id;
        $this->assertDatabaseHas('users', ['id' => $id]);
        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $test_user));
        $this->assertDatabaseMissing('users', ['id' => $id]);
    }

    public function testUserCannotDeleteUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $test_user = User::factory()->create();
        $id = $test_user->id;
        $this->assertDatabaseHas('users', ['id' => $id]);
        $this->actingAs($user)
            ->delete(route('admin.users.destroy', $test_user))
            ->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $id]);
    }

    public function testUserWithPermissionsCanDeleteUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $user->givePermissionTo('view dashboard', 'delete user');
        $test_user = User::factory()->create();
        $id = $test_user->id;
        $this->assertDatabaseHas('users', ['id' => $id]);
        $this->actingAs($user)
            ->delete(route('admin.users.destroy', $test_user));
        $this->assertDatabaseMissing('users', ['id' => $id]);
    }

    public function testSuperAdminCanEditUsers()
    {
        $admin = (User::factory()
            ->create())->assignRole(config('const.roles.super_admin'));
        $test_user = User::factory()->create();
        $this->actingAs($admin)
            ->get(route('admin.users.edit', $test_user))
            ->assertOk();
    }

    public function testUserCannotEditUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $test_user = User::factory()->create();
        $this->actingAs($user)
            ->get(route('admin.users.edit', $test_user))
            ->assertForbidden();
    }

    public function testUserWithPermissionsCanEditUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $user->givePermissionTo('view dashboard', 'update user');
        $test_user = User::factory()->create();
        $this->actingAs($user)
            ->get(route('admin.users.edit', $test_user))
            ->assertOk();
    }

    public function testSuperAdminCanUpdateUsers()
    {
        $admin = (User::factory()
            ->create())->assignRole(config('const.roles.super_admin'));
        $test_user = User::factory()->create();
        $id = $test_user->id;
        $this->actingAs($admin)
            ->patch(route('admin.users.update', $test_user), ['first_name' => 'test123'])
            ->assertValid();
        $this->assertDatabaseHas('users', [
            'id' => $id,
            'first_name' => 'test123'
        ]);
    }

    public function testUserCannotUpdateUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $test_user = User::factory()->create();
        $id = $test_user->id;
        $first_name = $test_user->first_name;
        $this->actingAs($user)
            ->patch(route('admin.users.update', $test_user), ['first_name' => 'test123'])
            ->assertForbidden();
        $this->assertDatabaseHas('users', [
            'id' => $id,
            'first_name' => $first_name
        ]);
    }

    public function testUserWithPermissionsCanUpdateUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $user->givePermissionTo('view dashboard', 'update user');
        $test_user = User::factory()->create();
        $id = $test_user->id;
        $this->actingAs($user)
            ->patch(route('admin.users.update', $test_user), ['first_name' => 'test123'])
            ->assertValid();
        $this->assertDatabaseHas('users', [
            'id' => $id,
            'first_name' => 'test123'
        ]);
    }

    public function testSuperAdminCanAddUsers()
    {
        $admin = (User::factory()
            ->create())->assignRole(config('const.roles.super_admin'));
        $this->actingAs($admin)
            ->get(route('admin.users.create'))
            ->assertOk();
    }

    public function testUserCannotAddUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $this->actingAs($user)
            ->get(route('admin.users.create'))
            ->assertForbidden();
    }

    public function testUserWithPermissionsCanAddUsers()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $user->givePermissionTo('view dashboard', 'create user');
        $this->actingAs($user)
            ->get(route('admin.users.create'))
            ->assertOk();
    }

    public function testSuperAdminCanStoreUser()
    {
        $admin = (User::factory()
            ->create())->assignRole(config('const.roles.super_admin'));
        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'first_name' => 'example',
                'last_name' => 'test',
                'email' => 'example_test@example.com',
                'password' => 'Password@123',
                'password_confirmation' => 'Password@123',
                'role' => ['user'],
            ])
            ->assertValid();
        $this->assertDatabaseHas('users', [
            'first_name' => 'example',
            'last_name' => 'test',
            'email' => 'example_test@example.com',
        ]);
    }

    public function testUserCannotStoreUser()
    {
        $user = (User::factory()
            ->create())->assignRole(config('const.roles.user'));
        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'first_name' => 'example',
                'last_name' => 'test',
                'email' => 'example_test@example.com',
                'password' => 'Password@123',
                'password_confirmation' => 'Password@123',
                'role' => ['user'],
            ])
            ->assertForbidden();
        $this->assertDatabaseMissing('users', [
            'first_name' => 'example',
            'last_name' => 'test',
            'email' => 'example_test@example.com',
        ]);
    }
}
