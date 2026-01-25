<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::Create([
            'user_type' => 1,
            'name' => 'System Admin',
            'username' => 'admin',
            'role_id' => 1,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('AAaa00@@'),
        ]);

        $role = Role::first();

        if ($role && $role->name == 'admin') {
            $admin->roles()->attach($role);
        } else {
            $this->command->warn('No role found or first role is not admin.');
        }
    }
}
