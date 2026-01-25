<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = ['view_users', 'edit_users', 'delete_users', 'add_users'];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}