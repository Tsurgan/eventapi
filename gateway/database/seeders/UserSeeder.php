<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'secret1234',
            'email_verified_at' => now(),
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'Org User',
            'email' => 'org@example.com',
            'password' => 'secret1234',
            'email_verified_at' => now(),
            'role_id' => 2,
        ]);
        User::create([
            'name' => 'Volunteer User',
            'email' => 'volunteer@example.com',
            'password' => 'secret1234',
            'email_verified_at' => now(),
            'role_id' => 3,
        ]);
        User::create([
            'name' => 'Visitor User',
            'email' => 'visitor@example.com',
            'password' => 'secret1234',
            'email_verified_at' => now(),
            'role_id' => 4,
        ]);
    }
}
