<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // -----------------------------
        // 1. Admin User
        // -----------------------------
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'phone' => '01776197999',
                'phone_2' => '01776197999',
                'password' => Hash::make('AAaa00@@'),
                'profile_picture' => null,
                'two_factor_enabled' => 0,
                'session_timeout' => 5,
                'is_maintenance' => 0,
                'is_banned' => 0,
            ]
        );
        $admin->assignRole('admin');

        // -----------------------------
        // 2. Manager User
        // -----------------------------
        $manager = User::updateOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'Manager User',
                'username' => 'manager',
                'phone' => '01776197999',
                'phone_2' => '01776197999',
                'password' => Hash::make('AAaa00@@'),
                'profile_picture' => null,
                'two_factor_enabled' => 0,
                'session_timeout' => 5,
                'is_maintenance' => 0,
                'is_banned' => 0,
            ]
        );
        $manager->assignRole('manager');

        // -----------------------------
        // 3. Regular User
        // -----------------------------
        $user = User::updateOrCreate(
            ['email' => 'demo@gmail.com'],
            [
                'name' => 'Demo User',
                'username' => 'demo',
                'phone' => '01776197999',
                'phone_2' => '01776197999',
                'password' => Hash::make('AAaa00@@'),
                'profile_picture' => null,
                'two_factor_enabled' => 0,
                'session_timeout' => 5,
                'is_maintenance' => 0,
                'is_banned' => 0,
            ]
        );
        $user->assignRole('user');

        $user2 = User::updateOrCreate(
            ['email' => 'demo2@gmail.com'],
            [
                'name' => 'Demo User 2',
                'username' => 'demo_2',
                'phone' => '01776197999',
                'phone_2' => '01776197999',
                'password' => Hash::make('AAaa00@@'),
                'profile_picture' => null,
                'two_factor_enabled' => 0,
                'session_timeout' => 5,
                'is_maintenance' => 0,
                'is_banned' => 0,
            ]
        );
        $user2->assignRole('user');

        // -----------------------------
        // Optional: Another admin
        // -----------------------------
        $admin2 = User::updateOrCreate(
            ['email' => 'admin2@gmail.com'],
            [
                'name' => 'Admin 2',
                'username' => 'admin2',
                'phone' => '01776197999',
                'phone_2' => '01776197999',
                'password' => Hash::make('AAaa00@@'),
                'profile_picture' => null,
                'two_factor_enabled' => 0,
                'session_timeout' => 5,
                'is_maintenance' => 0,
                'is_banned' => 0,
            ]
        );
        $admin2->assignRole('admin');
    }
}
