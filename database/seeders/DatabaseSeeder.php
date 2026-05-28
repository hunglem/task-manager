<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $superUser = User::firstOrCreate(
            ['email' => env('SUPER_USER_EMAIL', 'super@example.com')],
            [
                'name' => env('SUPER_USER_NAME', 'Super User'),
                'password' => env('SUPER_USER_PASSWORD', 'password'),
            ],
        );

        $superUser->forceFill(['is_super_user' => true])->save();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
