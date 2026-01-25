<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ViewPermission;

class ViewPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = ['dashboard', 'tender_menu', 'setting_menu'];

        foreach ($permissions as $viewName) {
            ViewPermission::create([
                'role_id'   => 1,
                'view_name' => $viewName,
                'status'    => 'active',
            ]);
        }
    }
}
