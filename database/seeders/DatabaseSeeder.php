<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Config;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => Config::get('const.roles.super_admin')]);
        Role::create(['name' => Config::get('const.roles.user')]);

        $permissions = [
            'view user',
            'create user',
            'update user',
            'view users',
            'delete user'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
