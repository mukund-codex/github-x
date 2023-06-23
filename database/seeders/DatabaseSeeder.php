<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App;
use App\Models\User;
use Config;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class
        ]);

        // \App\Models\User::factory(10)->create();

        if (App::environment() === 'local' || App::runningUnitTests()) {
            User::updateOrCreate([
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('Password@123'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ])->assignRole('super_admin');
        }
    }
}
