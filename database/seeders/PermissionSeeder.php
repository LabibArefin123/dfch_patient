<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Profile
            'home',
            'profile.management',
            'profile',
            'user_profile_edit',
            'user_profile_update',
            'profile_picture_edit',
            'profile_picture_update',
            'user_password_update',
            'user_password_edit',
            'user_password_reset',

            'organizations.index',
            'organizations.create',
            'organizations.store',
            'organizations.show',
            'organizations.edit',
            'organizations.update',
            'organizations.destroy',

            // Tenders
            'tenders.index',
            'tenders.create',
            'tenders.store',
            'tenders.update',
            'tenders.edit',
            'tenders.destroy',
            'tenders.downloadSpec',
            'tenders.downloadNotice',
            'tenders.updateStatus',
            'bg_pg.index',

            // BG & PG
            'bg.index',
            'bg.create',
            'bg.store',
            'bg.show',
            'bg.edit',
            'bg.update',
            'bg.destroy',
            'pg.index',
            'pg.create',
            'pg.store',
            'pg.show',
            'pg.edit',
            'pg.update',
            'pg.destroy',

            // Participated Tenders
            'participated_tenders.index',
            'tenders.participated.data',
            'participated_tenders.create',
            'participated_tenders.store',
            'participated_tenders.edit',
            'participated_tenders.update',
            'participated_tenders.destroy',
            'tender.mytender',
            'participated_tenders.reject',
            'rejected_tenders.index',

            // Awarded Tenders
            'awarded_tenders.index',
            'awarded_tenders.create',
            'awarded_tenders.store',
            'awarded_tenders.edit',
            'awarded_tenders.update',
            'awarded_tenders.destroy',
            'awarded_tenders.first_time_data',
            'awarded_tenders.partial_data',

            // Completed Tenders
            'completed_tenders.index',

            // Permissions & Roles
            'permissions.index',
            'permissions.create',
            'permissions.store',
            'permissions.edit',
            'permissions.update',
            'permissions.destroy',

            'roles.index',
            'roles.create',
            'roles.store',
            'roles.edit',
            'roles.update',
            'roles.destroy',

            'view-permission.index',
            'view-permission.create',
            'view-permission.store',
            'view-permission.show',
            'view-permission.edit',
            'view-permission.update',
            'view-permission.destroy',

            // Users & Settings
            'system_users.index',
            'system_users.create',
            'system_users.store',
            'system_users.show',
            'system_users.edit',
            'system_users.update',
            'system_users.destroy',

            'settings.index',
            'progress.data',
            'awarded.data',
            'participate.data',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign all permissions to 'admin' role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());
    }
}
