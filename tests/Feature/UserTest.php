<?php

namespace Tests\Feature;

use App\Models\User;
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
        $response->assertStatus(200);
    }

    public function test_get_users_list_not_allowed()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get(route('users.index'));
        $response->assertStatus(403);
    }

}
