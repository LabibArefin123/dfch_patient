<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Route;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(25);
        return view('backend.setting_management.roles_and_permission.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = \Spatie\Permission\Models\Permission::all();

        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0]; // user.create → user
        });

        return view(
            'backend.setting_management.roles_and_permission.roles.create',
            compact('groupedPermissions')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        // Create the new role
        $role = Role::create(['name' => $request->name]);

        // Handle attached permissions if available
        if ($request->filled('permissions')) {
            foreach ($request->permissions as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }

            // Attach permissions to the role
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $rolePermissions = $role->permissions()->pluck('name')->toArray();

        $permissions = Permission::orderBy('name')->get();

        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        return view(
            'backend.setting_management.roles_and_permission.roles.edit',
            compact(
                'role',
                'rolePermissions',
                'groupedPermissions'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        // Update role name
        $role->name = $request->name;
        $role->save();

        // Handle permissions
        if ($request->filled('permissions')) {
            foreach ($request->permissions as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }

            $role->syncPermissions($request->permissions);
        } else {
            // If no permissions sent, remove all
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }


    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return back()->with('error', 'Role not found.');
        }

        $role->delete();

        return back()->with('success', 'Role deleted successfully.');
    }
}
