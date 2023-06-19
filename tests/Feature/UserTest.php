<?php

namespace Tests\Feature;

use App\Models\User;
use Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_users_list()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view users');
        Sanctum::actingAs($user);
        $response = $this->get(route('users.index'));
        $response->assertOk();
        $response->assertJsonStructure(
            [
                'data' => [[
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ]]
            ]
        );
    }

    public function test_get_users_list_not_allowed()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get(route('users.index'));
        $response->assertForbidden();
    }

    public function test_get_user_details()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view user');
        Sanctum::actingAs($user);
        $response = $this->get(route('users.show', $user));
        $response->assertOk();
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ]
            ]
        );
    }

    public function test_add_user()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('create user');
        Sanctum::actingAs($user);
        $response = $this->post(route('users.store'), [
            'first_name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'Admin@123',
            'password_confirmation' => 'Admin@123',
            'role' => Config::get('const.roles.user')
        ]);

        $id = $response->decodeResponseJson()['data']['id'];
        $response->assertCreated();
        $response->assertSee(__('messages.user.registered'));
        $this->assertDatabaseHas('users', [
            'first_name' => 'Test'
        ]);
        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $id,
        ]);
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ]
            ]
        );
    }

//    public function test_update_user()
//    {
//        $user = User::factory()->create();
//        $user->givePermissionTo('update user');
//        $sanctum = Sanctum::actingAs($user);
//        $response = $this->patch(route('users.update', $user), [
//            'first_name' => 'Test123',
//        ]);
//
//        $response->assertOk();
//        $response->assertSee(__('messages.user.updated'));
//        $this->assertDatabaseHas('users', [
//            'first_name' => 'Test123'
//        ]);
//        $response->assertJsonStructure(
//            [
//                'data' => [
//                    'id',
//                    'first_name',
//                    'last_name',
//                    'email',
//                    'email_verified_at',
//                    'created_at',
//                    'updated_at',
//                ]
//            ]
//        );
//    }

    public function test_delete_user()
    {
        $user_to_delete = User::factory()->create();
        $id = $user_to_delete->id;
        $user = User::factory()->create();
        $user->givePermissionTo('delete user');
        Sanctum::actingAs($user);
        $response = $this->delete(route('users.destroy', $user_to_delete));

        $response->assertOk();
        $response->assertSee(__('messages.user.deleted'));
        $this->assertDatabaseMissing('users', [
            'id' => $id
        ]);
    }

}
