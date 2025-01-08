<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if(!User::first()){
            User::create([
                'name' => 'master',
                'phone' => "09124854432",
                'password' => 'ttM*1403',
                'user_type' => 2
            ]);
        }

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class
        ]);
//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
