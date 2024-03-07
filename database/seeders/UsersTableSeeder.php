<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'image' => null,
            'designation' => 'Administrator',
            'mobile' => '1234567890',
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create regular users
        for ($i = 1; $i <= 20; $i++) {
            DB::table('users')->insert([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'image' => null,
                'designation' => 'User',
                'mobile' => '123456789' . $i,
                'role' => 'user',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
