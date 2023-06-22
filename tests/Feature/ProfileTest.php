<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('profile.update', $user));
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

    public function test_update_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'first_name' => 'Test123',
        ]);
        $response->assertOk();
        $response->assertSee(__('messages.profile.updated'));
        $this->assertDatabaseHas('users', [
            'first_name' => 'Test123'
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

    public function test_delete_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete(route('profile.destroy'));

        $response->assertOk();
        $response->assertSee(__('messages.profile.deleted'));
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

}
